<?php
include 'views/header.php';
?>

<h2>Ringkasan Karyawan</h2>

<p style="margin-bottom: 2rem; color: #666;">
    Ringkasan menggunakan fungsi COUNT(), SUM(), AVG()
</p>

<!-- Cards Summary -->
<div class="dashboard-cards">
    <div class="card">
        <h3>Total Karyawan</h3>
        <div class="number"><?php echo $overview['total_employees']; ?></div>
        <p style="margin-top: 0.5rem; color: #666;">Karyawan aktif</p>
    </div>
    
    <div class="card">
        <h3>Total Gaji Per Bulan</h3>
        <div class="number" style="font-size: 1.5rem;">
            Rp <?php echo number_format($overview['total_monthly_salary'], 0, ',', '.'); ?>
        </div>
        <p style="margin-top: 0.5rem; color: #666;">Budget gaji bulanan</p>
    </div>
    
    <div class="card">
        <h3>Rata-rata Masa Kerja</h3>
        <div class="number"><?php echo number_format($overview['avg_years_service'], 1); ?></div>
        <p style="margin-top: 0.5rem; color: #666;">Tahun</p>
    </div>
    
    <div class="card">
        <h3>Rata-rata Gaji</h3>
        <div class="number" style="font-size: 1.3rem;">
            Rp <?php echo number_format(($overview['total_monthly_salary'] / $overview['total_employees']), 0, ',', '.'); ?>
        </div>
        <p style="margin-top: 0.5rem; color: #666;">Per karyawan</p>
    </div>
</div>

<!-- Detail Information -->
<div style="margin-top: 3rem; background: white; padding: 2rem; border-radius: 8px; border-left: 4px solid #667eea;">
    <h3>Detail Informasi</h3>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-top: 1rem;">
        <div>
            <h4 style="color: #667eea; margin-bottom: 1rem;">Budget Tahunan</h4>
            <p style="font-size: 1.8rem; font-weight: bold; color: #333;">
                Rp <?php echo number_format(($overview['total_monthly_salary'] * 12), 0, ',', '.'); ?>
            </p>
            <p style="color: #666;">Total gaji 12 bulan</p>
        </div>
        
        <div>
            <h4 style="color: #28a745; margin-bottom: 1rem;">Rata-rata Per Tahun Kerja</h4>
            <p style="font-size: 1.8rem; font-weight: bold; color: #333;">
                Rp <?php echo number_format(($overview['total_monthly_salary'] / $overview['total_employees'] / $overview['avg_years_service']), 0, ',', '.'); ?>
            </p>
            <p style="color: #666;">Gaji per tahun masa kerja</p>
        </div>
    </div>
</div>

<!-- Fungsi yang Digunakan -->
<div style="margin-top: 2rem; padding: 1.5rem; background: #f8f9fa; border-radius: 8px;">
    <h4>Fungsi PostgreSQL yang Digunakan:</h4>
    <ul style="margin-top: 1rem; line-height: 2;">
        <li><code>COUNT(*)</code> - Menghitung total karyawan</li>
        <li><code>SUM(salary)</code> - Menjumlahkan total gaji per bulan</li>
        <li><code>AVG(EXTRACT(YEAR FROM AGE(...)))</code> - Menghitung rata-rata masa kerja</li>
    </ul>
</div>

<?php include 'views/footer.php'; ?>