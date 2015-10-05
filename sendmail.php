<?php
session_start();
mail('onetimeisawabird@gmail.com','Account Balance Exceeded','Your account threshold has been exceeded. Please review your account','From: admin@telecom.com');
?>