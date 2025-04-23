<?php
/**
 * Plugin Name: SIP Calculator
 * Plugin URI: 
 * Description: A simple SIP calculator for WordPress.
 * Version: 1.0
 * Author: Ankit singla
 * Author URI: 
 * License: GPL2
 */

// Hook to add the plugin's functionality to WordPress
function sip_calculator_shortcode() {
    ob_start(); ?>

    <!-- HTML form for SIP calculator -->
    <div class="sip-calculator-container">
        <h1>SIP Calculator</h1>
        <form action="" method="POST">
            <label for="sip_amount">Monthly SIP Amount (in ₹):</label>
            <input type="number" id="sip_amount" name="sip_amount" required>
            
            <label for="years">Investment Duration (in Years):</label>
            <input type="number" id="years" name="years" required>
            
            <label for="rate_of_return">Expected Rate of Return (in %):</label>
            <input type="number" id="rate_of_return" name="rate_of_return" required>
            
            <input type="submit" value="Calculate">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $sip_amount = $_POST['sip_amount'];
            $years = $_POST['years'];
            $rate_of_return = $_POST['rate_of_return'];
            
            // Function to calculate SIP maturity value
            function calculateSIP($sip_amount, $years, $rate_of_return) {
                $months = $years * 12; // Total number of months
                $rate_of_return_monthly = $rate_of_return / 12 / 100; // Monthly rate of return

                $future_value = 0;
                // Calculate the future value of SIP using the formula
                for ($i = 1; $i <= $months; $i++) {
                    $future_value += $sip_amount * pow(1 + $rate_of_return_monthly, $months - $i);
                }

                return round($future_value, 2);
            }

            // Calculate the maturity amount
            $maturity_amount = calculateSIP($sip_amount, $years, $rate_of_return);
            ?>

            <div class="sip-result">
                <h2>SIP Maturity Calculation</h2>
                <p><strong>Monthly SIP Amount:</strong> ₹<?php echo number_format($sip_amount, 2); ?></p>
                <p><strong>Investment Duration:</strong> <?php echo $years; ?> Years</p>
                <p><strong>Expected Rate of Return:</strong> <?php echo $rate_of_return; ?>%</p>
                <p><strong>Total Maturity Value:</strong> ₹<?php echo number_format($maturity_amount, 2); ?></p>
            </div>
        <?php
        }
        ?>

    </div>

    <style>
        .sip-calculator-container {
            width: 60%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        .sip-calculator-container h1 {
            text-align: center;
            color: #333;
        }
        .sip-calculator-container label {
            font-size: 16px;
            display: block;
            margin: 10px 0 5px;
        }
        .sip-calculator-container input[type="number"], .sip-calculator-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin: 5px 0 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .sip-result {
            text-align: center;
            padding: 20px;
            margin-top: 20px;
            background-color: #e9f7ef;
            border: 1px solid #d1f2d6;
            border-radius: 5px;
        }
    </style>

    <?php
    return ob_get_clean();
}

// Register the SIP calculator shortcode
function sip_calculator_shortcode_register() {
    add_shortcode('sip_calculator', 'sip_calculator_shortcode');
}

add_action('init', 'sip_calculator_shortcode_register');
?>
