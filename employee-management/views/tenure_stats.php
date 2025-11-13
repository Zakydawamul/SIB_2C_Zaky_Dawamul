<?php
include 'views/header.php';
?>

<h2>Statistik Masa Kerja Karyawan</h2>

<p style="margin-bottom: 2rem; color: #666;">
    Karyawan dikelompokkan berdasarkan masa kerja menggunakan CASE WHEN dan COUNT()
</p>

<?php if ($tenure_stats->rowCount() > 0): ?>
    
    <!-- Cards Summary -->
    <div class="dashboard-cards">
        <?php 
        $all_tenure = $tenure_stats->fetchAll(PDO::FETCH_ASSOC);
        foreach ($all_tenure as $tenure): 
        ?>
        <div class="card">
            <h3><?php echo $tenure['tenure_level']; ?></h3>
            <div class="number"><?php echo $tenure['employee_count']; ?></div>
            <p style="margin-top: 0.5rem; color: #666;">
                Rata-rata Gaji: Rp <?php echo number_format($tenure['avg_salary'], 0, ',', '.'); ?>
            </p>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Tabel Detail -->
    <table class="data-table" style="margin-top: 2rem;">
        <thead>
            <tr>
                <th>Level Masa Kerja</th>
                <th>Jumlah Karyawan</th>
                <th>Rata-rata Gaji</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total = array_sum(array_column($all_tenure, 'employee_count'));
            foreach ($all_tenure as $tenure): 
            ?>
            <tr>
                <td>
                    <strong><?php echo $tenure['tenure_level']; ?></strong>
                    <br>
                    <small style="color: #666;">
                        <?php 
                        if ($tenure['tenure_level'] == 'Junior') echo '< 1 tahun';
                        elseif ($tenure['tenure_level'] == 'Middle') echo '1-3 tahun';
                        else echo '> 3 tahun';
                        ?>
                    </small>
                </td>
                <td style="text-align: center;">
                    <span style="padding: 0.25rem 0.75rem; background: #28a745; color: white; border-radius: 20px;">
                        <?php echo $tenure['employee_count']; ?> orang
                    </span>
                </td>
                <td>Rp <?php echo number_format($tenure['avg_salary'], 0, ',', '.'); ?></td>
                <td>
                    <strong><?php echo number_format(($tenure['employee_count'] / $total * 100), 1); ?>%</strong>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php else: ?>
    <p>Tidak ada data statistik masa kerja.</p>
<?php endif; ?>

<div style="margin-top: 2rem; padding: 1rem; background: #e7f3ff; border-radius: 5px;">
    <strong>ℹ️ Informasi:</strong>
    Data dikelompokkan menggunakan fungsi CASE WHEN berdasarkan masa kerja karyawan.
</div>

<?php include 'views/footer.php'; ?>