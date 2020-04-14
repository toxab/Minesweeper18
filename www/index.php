<?php

/**
 * Class Minesweeper
 */
class Minesweeper {
    
    /**
     * @var array
     */
   private $minesweeperArray      = [];
   
    /**
     * @var int
     */
    private $k;
    
    /**
     * @var int
     */
    private  $n;
    
    /**
     * @var int
     */
    private  $m;
    
    /**
     * @var array
     */
    private  $oneCoordinates    = [];
    
    /**
     * @var array
     */
    private  $eightCoordinates  = [];
    
    
    /**
     * Minesweeper constructor.
     * @param int $k
     * @param int $n
     * @param int $m
     */
    public function __construct($k = 4, $n = 10, $m = 10)
   {
       $this->k =  isset($_REQUEST['k_request']) ? $_REQUEST['k_request'] : $k;
       $this->n = isset($_REQUEST['n_request']) ? $_REQUEST['n_request'] : $n;
       $this->m = isset($_REQUEST['m_request']) ? $_REQUEST['m_request'] : $m;
       $this->dimensionMinesweeperArray();
   }
    
    /**
     * @return int
     */
    public function getK ()
   {
       return $this->k;
   }
    
    /**
     * @return int
     */
    public function getN ()
   {
       return $this->n;
   }
    
    /**
     * @return int
     */
    public function getM ()
   {
       return $this->m;
   }
    
    /**
     * @return array
     */
    public function dimensionMinesweeperArray (): array
   {
       for ($indexN = 0; $indexN <= $this->getN(); $indexN++) {
           for ($indexM = 0; $indexM <= $this->getM(); $indexM++) {
               $this->minesweeperArray[$indexN][] = '';
           }
       }
       return $this->minesweeperArray;
   }
    
    /**
     * @return array
     */
    public function getMinesweeperFullArray (): array
   {
       return $this->minesweeperArray;
   }
    
   public function getMinesweeperArrayNumber ($n, $m): string
   {
       return $this->minesweeperArray[$n][$m];
   }
    
    /**
     * @param $n
     * @param $m
     * @param $value
     */
    public function setMinesweeperArray($n, $m, $value): void
   {
       $this->minesweeperArray[$n][$m] = $value;
   }
    
    
    /**
     * @return mixed
     */
    public function generate(){
        
        echo "<table style='border-collapse:collapse;border-spacing:0;border:3px solid #000;'>";
        $iLength = $this->getN();
        $jLength = $this->getM();
        for($i = 0; $i < $iLength;$i++){
            $ts = '';
            echo "<tr $ts>";
            for($j = 0; $j < $jLength; $j++){
               
                $td = '';
                echo "<td style='width:40px;height:40px;text-align:center;border:1px solid #000;font-size: 30px;$td'>".$this->getMinesweeperArrayNumber($i,$j)."</td>";
            }
            echo "</tr>";
        }
        
        echo "</table>";
        
    }
    
    /**
     * @param int $upCrossLeftX
     * @param int $upCrossLeftY
     * @param int $upCrossRightX
     * @param int $upCrossRightY
     * @param int $downCrossLeftX
     * @param int $downCrossLeftY
     * @param int $downCrossRightX
     * @param int $downCrossRightY
     */
    public function sumByCrossOne (int $upCrossLeftX,
                                   int $upCrossLeftY,
                                   int $upCrossRightX,
                                   int $upCrossRightY,
                                   int $downCrossLeftX,
                                   int $downCrossLeftY,
                                   int $downCrossRightX,
                                   int $downCrossRightY
    ): void
    {
        $this->setMinesweeperArray($upCrossLeftX, $upCrossLeftY, 2);
        $this->setMinesweeperArray($upCrossRightX, $upCrossRightY, 2);
        $this->setMinesweeperArray($upCrossRightX, $upCrossRightY, 2);
        $this->setMinesweeperArray($downCrossLeftX, $downCrossLeftY, 2);
        $this->setMinesweeperArray($downCrossRightX, $downCrossRightY, 2);
    }
    
    /**
     * @return mixed
     */
    public function randomEightAndOne (): void
   {

       if (empty( $this->getK())) return;
       
       for ($i = 0; $i < $this->getK(); $i++) {
           $nCoord =  mt_rand(0,$this->getN());
           $mCoord =  mt_rand(0,$this->getM());

            
            $up = $nCoord -1 <= 0 ? [0, $mCoord] : [$nCoord - 1, $mCoord];
            $down = [$nCoord + 1, $mCoord];
            $left = [$nCoord, $mCoord - 1];
            $right = [$nCoord, $mCoord +1];
            $upLeftCross = $nCoord -1 <= 0 ? [0, $mCoord - 1] : [$nCoord - 1, $mCoord -1];
            $upRightCross = $nCoord -1 <= 0 ? [0, $mCoord + 1] : [$nCoord - 1, $mCoord +1];
            $downLeftCross = [$nCoord + 1, $mCoord - 1];
            $downRightCross = [$nCoord + 1, $mCoord + 1];
            
            list($upX, $upY) = $up;
            list($downX, $downY) = $down;
            list($leftX, $leftY) = $left;
            list($rightX, $rightY) = $right;
            
            list($upCrossLeftX, $upCrossLeftY) = $upLeftCross;
            list($upCrossRightX, $upCrossRightY) = $upRightCross;
            list($downCrossLeftX, $downCrossLeftY) = $downLeftCross;
            list($downCrossRightX, $downCrossRightY) = $downRightCross;
    
           if (count($this->oneCoordinates) >= 1) {
               if ($this->checkArray($this->oneCoordinates, $up) !== false
                   && $this->checkArray($this->oneCoordinates, $down) !== false
                   && $this->checkArray($this->oneCoordinates, $left) !== false
                   && $this->checkArray($this->oneCoordinates, $right) !== false
                   && $this->checkArray($this->oneCoordinates, [$nCoord, $mCoord]) !== false
               )
               {
    
                   if (!empty($this->oneCoordinates)) {
                       $this->oneCoordinates[] = [$up, $down, $left, $right];
                   }
    
                   $this->eightCoordinates[] = [$nCoord, $mCoord];
    
                   $this->setMinesweeperArray($nCoord, $mCoord, 8);
                   
                   $this->setMinesweeperArray($upX, $upY, 1);
                   $this->setMinesweeperArray($downX, $downY, 1);
                   $this->setMinesweeperArray($leftX, $leftY, 1);
                   $this->setMinesweeperArray($rightX, $rightY, 1);
    
                   $this->sumByCrossOne(
                       $upCrossLeftX,
                       $upCrossLeftY,
                       $upCrossRightX,
                       $upCrossRightY,
                       $downCrossLeftX,
                       $downCrossLeftY,
                       $downCrossRightX,
                       $downCrossRightY
                   );
        
               }
           } else {
    
               $this->setCoordinates($up, $down, $left, $right, $nCoord, $mCoord, $upX, $upY, $downX, $downY, $leftX,
                   $leftY, $rightX, $rightY);
               $this->sumByCrossOne(
                                   $upCrossLeftX,
                                   $upCrossLeftY,
                                   $upCrossRightX,
                                   $upCrossRightY,
                                   $downCrossLeftX,
                                   $downCrossLeftY,
                                   $downCrossRightX,
                                   $downCrossRightY
               );
           }
       }
       while (count($this->oneCoordinates) < $this->getK() ) {
           $this->randomEightAndOne();
       }
    
   }
   
   
   public function checkArray ($array, $search)
   {
       $flag = true;
       foreach ($array as $items) {
           foreach ($items as $value) {
             if (!array_diff($value, $search)) {
                 $flag = false;
             }
           }
       }
       return $flag;
   }
    
    /**
     * @param array $up
     * @param array $down
     * @param array $left
     * @param array $right
     * @param int   $nCoord
     * @param int   $mCoord
     * @param       $upX
     * @param       $upY
     * @param       $downX
     * @param       $downY
     * @param       $leftX
     * @param       $leftY
     * @param       $rightX
     * @param       $rightY
     */
    public function setCoordinates(array $up,
                                   array $down,
                                   array $left,
                                   array $right,
                                   int $nCoord,
                                   int $mCoord,
                                   $upX,
                                   $upY,
                                   $downX,
                                   $downY,
                                   $leftX,
                                   $leftY,
                                   $rightX,
                                   $rightY
    ): void
    {
        $this->oneCoordinates[] = [$up, $down, $left, $right];
        
        $this->eightCoordinates[] = [$nCoord, $mCoord];
        
        $this->setMinesweeperArray($nCoord, $mCoord, 8);
        
        $this->setMinesweeperArray($upX, $upY, 1);
        $this->setMinesweeperArray($downX, $downY, 1);
        $this->setMinesweeperArray($leftX, $leftY, 1);
        $this->setMinesweeperArray($rightX, $rightY, 1);
    }
    
}

    
    ?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Minesweeper TEST GEN</title>
    <style type="text/css">
        .minesweeper {
            margin: 0 auto;
            margin-top: 100px;
        }
        .inline {
            display: block;
            padding: 15px;
        }
        .set-params {
            display: block;
            padding: 50px;
        }
    </style>
</head>
<body>
<div class="minesweeper">
    <?php $minesweeper = new Minesweeper(); ?>
    <div class="set-params">
        <form action="index.php" method="post">
            <p>by horizontal: <input type="text" name="n_request" value="<?php echo $minesweeper->getN(); ?>"/></p>
            <p>by horizontal: <input type="text" name="m_request" value="<?php echo $minesweeper->getM(); ?>"/></p>
            <p>amount of 8's: <input type="text" name="k_request" value="<?php echo $minesweeper->getK(); ?>" /></p>
            <p><input type="submit" /></p>
        </form>
        <?php
    ?>
    </div>
    <div class="inline">
        <?php
        $minesweeper->randomEightAndOne();
        $minesweeper->generate(); ?>
        
    </div>
 
</div>
</body>
</html>

