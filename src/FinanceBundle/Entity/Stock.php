<?php

namespace FinanceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stock
 *
 * @ORM\Table(name="stock")
 * @ORM\Entity(repositoryClass="FinanceBundle\Repository\StockRepository")
 */
class Stock
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="ticker", type="string", length=255, unique=true)
     */
    private $ticker;

    /**
     * @var int
     *
     * @ORM\Column(name="numShares", type="integer")
     */
    private $numShares;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="stocks")
     **/
    protected $user;


    /**
     * Get User
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set User
     *
     * @param string $user
     * @return Stock
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ticker
     *
     * @param string $ticker
     * @return Stock
     */
    public function setTicker($ticker)
    {
        $this->ticker = $ticker;

        return $this;
    }

    /**
     * Get ticker
     *
     * @return string 
     */
    public function getTicker()
    {
        return $this->ticker;
    }

    /**
     * Set numShares
     *
     * @param integer $numShares
     * @return Stock
     */
    public function setNumShares($numShares)
    {
        $this->numShares = $numShares;

        return $this;
    }

    /**
     * Get numShares
     *
     * @return integer 
     */
    public function getNumShares()
    {
        return $this->numShares;
    }
}
