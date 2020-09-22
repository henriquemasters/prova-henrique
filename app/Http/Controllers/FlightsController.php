<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FlightsController extends Controller {

    private $flights;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->cURL();
    }

    /**
     * Retorna todos os Vôos da API da 123 Milhas.
     *
     * @return array
     */
    public function getAll(): array {
        return $this->flights;
    }

    /**
     * Retorna um agrupamento de vôos IDA/VOLTA com base do Valor Total.
     *
     * @return array
     */
    public function doGroup(): array {
        $groupFares = $this->groupByFareAndPrice();
        $totalFlights = 0;
        foreach ($groupFares as $fare => $groupBounds) {
            krsort($groupBounds);
            //
            foreach (array_keys($groupBounds['outbound']) as $outPrices) {
                $totalFlights += count((array) $outPrices);
                //
                foreach (array_keys($groupBounds['inbound']) as $inPrices) {
                    $totalFlights += count((array) $inPrices);
                    //
                    $groups[($outPrices + $inPrices)] = array(
                        'uniqueId' => uniqid(),
                        'totalPrice' => ($outPrices + $inPrices),
                        'outbound' => $groupBounds['outbound'][$outPrices],
                        'inbound' => $groupBounds['inbound'][$inPrices]
                    );
                }
            }
        }
        //  ksort($groups);
        return ['groups' => $groups, 'totalGroups' => count($groups), 'totalFlights' => $totalFlights];
    }

    /**
     * Retorna a lista de Grupos ordenado pelo menor Preço.
     *
     * @return array
     */
    public function doSort(): array {
        $src = $this->doGroup();
        ksort($src['groups']);
        return $src;
    }

    /**
     * Retorna um objeto Json com os vôos agrupados.
     *
     * @return array
     */
    public function groupFlights(): array {
        $_group = $this->doSort();
        //
        $return['flights'] = $this->flights;
        $return['groups'] = array_values($_group['groups']);
        $return['totalGroups'] = $_group['totalGroups'];
        $return['totalFlights'] = $_group['totalFlights'];
        $return['cheapestPrice'] = min(array_keys($_group['groups']));
        $return['cheapestGroup'] = $_group['groups'][$return['cheapestPrice']]['uniqueId'];

        return $return;
    }

    /**
     * Recebe um Array de Objetos(Vôos) e os agrupa por Fare(Tarifa) e Price(Preço).
     *
     * @return array
     */
    private function groupByFareAndPrice(): array {
        foreach ($this->flights as $key => $flight) {
            if (isset($flight->fare))
                $return[$flight->fare][($flight->outbound) ? 'outbound' : 'inbound'][$flight->price][] = $flight;
        }
        return $this->orderByPrice($return);
    }

    /**
     * Ordena o Array de "Vôos" pelo Preço (Crescente).
     *
     * @param array $groupFares
     * @return array
     */
    private function orderByPrice(array $groupFares): array {
        foreach ($groupFares as $fare => $groupPrices) {
            ksort($groupFares[$fare]);
        }
        return $groupFares;
    }

    /**
     * Chama através do cURL a API e consome seu resultado.
     *
     * @return void
     */
    private function cURL(): void {
        $ch = curl_init('http://prova.123milhas.net/api/flights');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $this->flights = json_decode(curl_exec($ch));
        curl_close($ch);
    }

}
