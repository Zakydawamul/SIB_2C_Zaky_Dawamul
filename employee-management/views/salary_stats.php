<?php
include 'views/header.php';
?>

<h2>Statistik Gaji per Departemen</h2>

<p style="margin-bottom: 2rem; color: #666;">
    Statistik gaji menggunakan fungsi agregat: AVG(), MAX(), MIN(), GROUP BY
</p>

<?php if ($salary_stats->rowCount() > 0): ?>
    
    <table class="data-table">
        <thead>
            <tr>
                <th>Departemen</th>
                <th>Jumlah Karyawan</th>
                <th>Rata-rata Gaji</th>
                <th>Gaji Tertinggi</th>
                <th>Gaji Terendah</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $salary_stats->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><strong><?php echo htmlspecialchars($row['department']); ?></strong></td>
                <td style="text-align: center;">
                    <span style="padding: 0.25rem 0.75rem; background: #667eea; color: white; border-radius: 20px;">
                        <?php echo $row['employee_count']; ?>
                    </span>
                </td>
                <td><strong>Rp <?php echo number_format($row['avg_salary'], 0, ',', '.'); ?></strong></td>
                <td>Rp <?php echo number_format($row['max_salary'], 0, ',', '.'); ?></td>
                <td>Rp <?php echo number_format($row['min_salary'], 0, ',', '.'); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Visualisasi -->
    <div style="margin-top: 3rem;">
        <h3>Visualisasi Rata-rata Gaji per Departemen</h3>
        <?php 
        $salary_stats->execute();
        while ($dept = $salary_stats->fetch(PDO::FETCH_ASSOC)): 
        ?>
        <div style="margin: 1rem 0;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                <span><?php echo htmlspecialchars($dept['department']); ?></span>
                <span>Rp <?php echo number_format($dept['avg_salary'], 0, ',', '.'); ?></span>
            </div>
            <div style="background: #f0f0f0; border-radius: 4px; height: 25px;">
                <div style="background: #667eea; height: 100%; border-radius: 4px; width: <?php echo ($dept['avg_salary'] / 11000000 * 100); ?>%;"></div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

<?php else: ?>
    <p>Tidak ada data statistik gaji.</p>
<?php endif; ?>

<?php include 'views/footer.php'; ?>