<?php

namespace FinanceBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Themes\UniversalTheme;
use Amenadiel\JpGraph\Plot\LinePlot;
use FinanceBundle\Lib\YahooFinance;


class PlotController extends Controller
{
    /**
     * @Route("/plot")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $currentUser = $this->container->get('security.context')->getToken()->getUser();
        $stocks = $em->getRepository('FinanceBundle:Stock')->findByUser($currentUser);

        $protValue = array();
        $labels = array();
        $currentTime = time();
        $numberOfYears = 2;
        for ($i=0;$i<2;$i++) {
            $oneYearAgo = strtotime("-1 year", $currentTime);
            foreach ($stocks as $stock) {
                $yf = new YahooFinance;
                $historicaldata = $yf->getHistoricalData($stock->getTicker(), date("Y-m-d",$oneYearAgo),  date("Y-m-d",$currentTime));

                $obj = json_decode($historicaldata, true);
                if ($obj['query']['count'] > 0) {


                    foreach ($obj['query']['results']['quote'] as $item) {
                        $totalValue = $item['Close'] * $stock->getNumShares();
                        if (empty($protValue[strtotime($item['Date'])])) {
                            $protValue[strtotime($item['Date'])] = $totalValue;
                        } else {
                            $protValue[strtotime($item['Date'])] = $protValue[strtotime($item['Date'])] + $totalValue;
                        }
                        $labels[strtotime($item['Date'])] = $item['Date'];
                    }
                }
            }
            $currentTime =strtotime("-1 day", $oneYearAgo);;
        }

        if (count($protValue)==0) {
            echo "No Data";
            return $this->render('FinanceBundle:Plot:index.html.twig', array(
                // ...
            ));
        }else {
            $datay1 = array_reverse(array_values($protValue));
            $labels = array_reverse(array_values($labels));


            // Setup the graph
            $graph = new Graph(2000, 1500);
            $graph->SetScale("datlin");

            $theme_class = new UniversalTheme;

            $graph->SetTheme($theme_class);
            $graph->img->SetAntiAliasing(false);
            $graph->title->Set('Filled Y-grid');
            $graph->SetBox(false);

            $graph->img->SetAntiAliasing();

            $graph->yaxis->HideZeroLabel();
            $graph->yaxis->HideLine(false);
            $graph->yaxis->HideTicks(false, false);

            $graph->xgrid->Show();
            $graph->xgrid->SetLineStyle("solid");

            $graph->xaxis->SetTickLabels($labels);
            $graph->xaxis->SetLabelAngle(90);
            $graph->xgrid->SetColor('#E3E3E3');

            // Create the first line
            $p1 = new LinePlot($datay1);
            $graph->Add($p1);
            $p1->SetColor("#6495ED");
            $p1->SetLegend('Portfolio cost vs time');


            $graph->legend->SetFrameWeight(1);

            // Output line
//            $graph->Stroke();
            $gdImgHandler = $graph->Stroke(_IMG_HANDLER);
//Start buffering
            ob_start();
//Print the data stream to the buffer
            $graph->img->Stream();
//Get the conents of the buffer
            $image_data = ob_get_contents();
//Stop the buffer/clear it.
            ob_end_clean();
//Set the variable equal to the base 64 encoded value of the stream.
//This gets passed to the browser and displayed.
            $image = base64_encode($image_data);
            $redirect = $this->render('FinanceBundle:Plot:index.html.twig', array(
                'EncodedImage' => $image,
            ));
            return $redirect;
        }

    }

}
