<?php 
// public/admin/reports.php

// Load the shared admin header (handles AdminMiddleware security and layout)
require_once '../../app/Views/layouts/admin_header.php'; 

$db = Database::getInstance();

// 1. Get general stats
$stats = $db->query("SELECT 
    (SELECT COUNT(*) FROM customers) as total_customers,
    (SELECT COUNT(*) FROM accounts) as total_accounts,
    (SELECT SUM(balance) FROM accounts) as total_balance
")->fetch();

// 2. Get transaction counts for the Bar Chart
$txCounts = $db->query("
    SELECT transaction_type, COUNT(*) as count 
    FROM transactions 
    GROUP BY transaction_type
")->fetchAll(PDO::FETCH_KEY_PAIR);

$deposits = $txCounts['deposit'] ?? 0;
$withdrawals = $txCounts['withdrawal'] ?? 0;
$transfers = $txCounts['transfer'] ?? 0;

// 3. Get account type distribution for the Doughnut Chart
$accTypes = $db->query("
    SELECT account_type, COUNT(*) as count 
    FROM accounts 
    GROUP BY account_type
")->fetchAll(PDO::FETCH_KEY_PAIR);

$savingsCount = $accTypes['Savings'] ?? 0;
$currentCount = $accTypes['Current'] ?? 0;
?>

<!-- Summary Cards -->
<div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-left: 5px solid var(--primary-blue); display: flex; justify-content: space-between; align-items: center;">
        <div>
            <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0; text-transform: uppercase; font-weight: 600;">Total Customers</p>
            <h2 style="color: var(--primary-navy); margin: 0; font-size: 2rem;"><?= number_format($stats['total_customers']) ?></h2>
        </div>
        <div style="background: #eaf3ff; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary-blue);">
            <i class="fas fa-users fa-lg"></i>
        </div>
    </div>
    <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-left: 5px solid #17a2b8; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0; text-transform: uppercase; font-weight: 600;">Total Accounts</p>
            <h2 style="color: var(--primary-navy); margin: 0; font-size: 2rem;"><?= number_format($stats['total_accounts']) ?></h2>
        </div>
        <div style="background: #e0f7fa; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #17a2b8;">
            <i class="fas fa-wallet fa-lg"></i>
        </div>
    </div>
    <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-left: 5px solid #28a745; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0; text-transform: uppercase; font-weight: 600;">Total Bank Balance</p>
            <h2 style="color: var(--primary-navy); margin: 0; font-size: 1.6rem;"><?= formatRWF($stats['total_balance'] ?? 0) ?></h2>
        </div>
        <div style="background: #eafaf1; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #28a745;">
            <i class="fas fa-money-bill-trend-up fa-lg"></i>
        </div>
    </div>
</div>

<!-- Charts Grid -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 30px;">
    
    <!-- Bar Chart: Transaction Overview -->
    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
        <h3 style="color: var(--primary-navy); margin-top: 0; margin-bottom: 20px;">Transaction Volume</h3>
        <canvas id="barChart" style="max-height: 350px;"></canvas>
    </div>

    <!-- Doughnut Chart: Account Types -->
    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
        <h3 style="color: var(--primary-navy); margin-top: 0; margin-bottom: 20px;">Account Distribution</h3>
        <canvas id="doughnutChart" style="max-height: 350px;"></canvas>
    </div>
</div>

<!-- Chart.js Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 1. Bar Chart Data (Real DB Data)
    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: ['Deposits', 'Withdrawals', 'Transfers'],
            datasets: [{
                label: 'Number of Transactions',
                data: [<?= $deposits ?>, <?= $withdrawals ?>, <?= $transfers ?>],
                backgroundColor: [
                    'rgba(40, 167, 69, 0.8)',   // Green for Deposit
                    'rgba(220, 53, 69, 0.8)',   // Red for Withdrawal
                    'rgba(8, 102, 232, 0.8)'    // Blue for Transfer
                ],
                borderColor: [
                    '#28a745',
                    '#dc3545',
                    '#0866E8'
                ],
                borderWidth: 1,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });

    // 2. Doughnut Chart Data (Real DB Data)
    const doughnutCtx = document.getElementById('doughnutChart').getContext('2d');
    new Chart(doughnutCtx, {
        type: 'doughnut',
        data: {
            labels: ['Savings', 'Current'],
            datasets: [{
                data: [<?= $savingsCount ?>, <?= $currentCount ?>],
                backgroundColor: [
                    '#0866E8', // Blue for Savings
                    '#ffc107'  // Yellow for Current
                ],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        font: { size: 14 }
                    }
                }
            },
            cutout: '70%'
        }
    });
</script>

<?php require_once '../../app/Views/layouts/footer.php'; ?>