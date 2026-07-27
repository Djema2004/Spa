<?php
// app/controllers/CouponController.php

class CouponController extends Controller {

    public function index() {
        // Tableau vide en attendant de créer la table
        $coupons = []; 

        // Charger la vue
        require_once 'app/views/admin/coupons.php';
    }
}