<?php

namespace PaymentMethod\Controller;

/**
 * Class AbstractMobilePaymentController
 * @package PaymentMethod\Controller
 */
interface PaymentInterface
{
    public function authorizationSuccessAction();

    public function authorizationErrorAction();

    public function captureSuccessAction();

    public function captureErrorAction();

    public function paymentSuccessAction();

    public function paymentErrorAction();
}