<?php

use CFPP\Frontend\Shipping\ShippingMethods\ShippingMethodsAbstract;

class WC_Shipping_Free_Shipping_Shipping_Method extends ShippingMethodsAbstract {

    /**
    *   Returns the Display name for this Shipping Method
    */
    public function getName()
    {
        return 'Frete Grátis';
    }

    /**
    *   Receives a Request and calculates the shipping
    */
    public function calculate(array $request)
    {
        // Return 0 for Free Shipping, False otherwise.
        $should_show = $this->meetsFreeShippingRequirements($request) ? 'Grátis' : 'false';

        return array(
            'price' => $should_show,
            'days' => '-'
        );
    }

    /**
    *   Check if current request meets free shipping requirements
    */
    private function meetsFreeShippingRequirements(array $request)
    {
        if (empty($this->shipping_method->requires)) {
            return true;
        } elseif ($this->shipping_method->requires == 'min_amount' || $this->shipping_method->requires == 'either') {
            if (is_numeric($this->shipping_method->min_amount)) {
                if (($request['produto_preco'] * $request['quantidade']) > $this->shipping_method->min_amount) {
                    return true;
                }
            }
        }
        return false;
    }

}
