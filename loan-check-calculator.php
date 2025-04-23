<?php
/**
 * Plugin Name: Loan Check Calculator
 * Plugin URI: https://yourwebsite.com/
 * Description: A simple loan check calculator to calculate monthly payments, total repayment, and total interest.
 * Version: 1.0
 * Author: Your Name
 * Author URI: https://yourwebsite.com/
 * License: GPL2
 */

// Prevent direct access to this file
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Enqueue necessary styles and scripts
function loan_check_calculator_assets() {
    ?>
    <style>
        .loan-calculator-container {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin: auto;
        }

        .loan-calculator-container h1 {
            text-align: center;
            color: #333;
        }

        .loan-calculator-container .input-group {
            margin-bottom: 20px;
        }

        .loan-calculator-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        .loan-calculator-container input {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .loan-calculator-container button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .loan-calculator-container button:hover {
            background-color: #45a049;
        }

        .loan-calculator-container .result {
            background-color: #f4f7f6;
            padding: 15px;
            border-radius: 6px;
            margin-top: 20px;
            display: none;
            text-align: center;
        }

        .loan-calculator-container .result p {
            margin: 8px 0;
            font-size: 18px;
            color: #333;
        }

        .loan-calculator-container .result .amount {
            font-size: 24px;
            font-weight: bold;
            color: #2d2d2d;
        }
    </style>
    <script>
        // Function to calculate loan payments
        function calculateLoan() {
            // Get values from the form
            const loanAmount = parseFloat(document.getElementById('loanAmount').value);
            const interestRate = parseFloat(document.getElementById('interestRate').value) / 100;
            const loanTerm = parseInt(document.getElementById('loanTerm').value);

            // Validate inputs
            if (isNaN(loanAmount) || loanAmount <= 0 || isNaN(interestRate) || interestRate <= 0 || isNaN(loanTerm) || loanTerm <= 0) {
                alert('Please enter valid values for all fields.');
                return;
            }

            // Calculate monthly interest rate
            const monthlyInterestRate = interestRate / 12;

            // Calculate the number of payments
            const numberOfPayments = loanTerm * 12;

            // Calculate monthly payment using the formula
            const monthlyPayment = loanAmount * monthlyInterestRate / (1 - Math.pow(1 + monthlyInterestRate, -numberOfPayments));

            // Calculate total repayment and total interest
            const totalRepayment = monthlyPayment * numberOfPayments;
            const totalInterest = totalRepayment - loanAmount;

            // Display results
            document.getElementById('monthlyPayment').innerText = '₹' + monthlyPayment.toFixed(2);
            document.getElementById('totalRepayment').innerText = '₹' + totalRepayment.toFixed(2);
            document.getElementById('totalInterest').innerText = '₹' + totalInterest.toFixed(2);

            // Show the result section
            document.getElementById('result').style.display = 'block';
        }
    </script>
    <?php
}
add_action( 'wp_head', 'loan_check_calculator_assets' );

// Shortcode to display the loan calculator
function loan_check_calculator_shortcode() {
    ob_start();
    ?>
    <div class="loan-calculator-container">
        <h1>Loan Check Calculator</h1>

        <!-- Loan Input Form -->
        <div class="input-group">
            <label for="loanAmount">Loan Amount (₹)</label>
            <input type="number" id="loanAmount" placeholder="Enter loan amount" required>
        </div>

        <div class="input-group">
            <label for="interestRate">Interest Rate (%)</label>
            <input type="number" id="interestRate" placeholder="Enter interest rate" required>
        </div>

        <div class="input-group">
            <label for="loanTerm">Loan Term (years)</label>
            <input type="number" id="loanTerm" placeholder="Enter loan term" required>
        </div>

        <button onclick="calculateLoan()">Calculate Loan</button>

        <!-- Result Display -->
        <div class="result" id="result">
            <p><strong>Monthly Payment: </strong><span class="amount" id="monthlyPayment"></span></p>
            <p><strong>Total Repayment: </strong><span class="amount" id="totalRepayment"></span></p>
            <p><strong>Total Interest: </strong><span class="amount" id="totalInterest"></span></p>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'loan_calculator', 'loan_check_calculator_shortcode' );
?>
