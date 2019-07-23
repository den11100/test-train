<?php


namespace app\controllers;


class FractalController extends \yii\web\Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $x = 8;  // камни
        $y = 5;   //жуки

        $result[] = $x;

        while($y > 0 && $x >= 1) {

            $y--;

            $x = array_pop($result) - 1;

            $quotient = $x/2;

            if (($x % 2) == 0) {
                $big = $small = $quotient;
            } else {
                $big = intval(ceil($quotient));
                $small = intval(floor($quotient));
            }
            array_unshift($result, $small, $big);

            foreach ($result as $item) {
                if ($item > 1) {
                    sort($result);
                    break;
                }
            }
        }

        echo $result[0];
        echo $result[1];
        die;

//        return $this->render('index', [
//            'result' => $result,
//        ]);
    }
}

