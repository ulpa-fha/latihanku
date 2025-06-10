<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$query = "SELECT * FROM users ORDER BY id ASC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: rgb(151, 190, 248);
        }
        .dashboard-wrapper {
            max-width: 720px;
            margin: auto;
        }
        .card {
            border-radius: 1rem;
        }
        .btn-info {
            background-color: #0dcaf0;
            border-color: #0dcaf0;
        }
        .btn-info:hover {
            background-color: #31d2f2;
            border-color: #25cff2;
        }
        .btn-outline-danger:hover {
            color: white;
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>
<div class="container py-4 dashboard-wrapper">

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'berhasil_tambah'): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            Data pengguna berhasil ditambahkan!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="alert alert-success shadow-sm text-center">
        <h6>Halo, <strong><?= htmlspecialchars($_SESSION['nama_lengkap']) ?></strong></h6>
    </div>

    <div class="card shadow-sm mt-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <strong class="small mb-0">Daftar Pengguna</strong>
            <a href="tambah-user.php" class="btn btn-sm btn-light text-primary fw-bold">+ Tambah</a>
        </div>
        <div class="card-body p-3">
            <table class="table table-hover table-bordered table-sm align-middle small">
                <thead class="table-light text-center">
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th style="width: 25%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php $no = 1; ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                                <td><?= htmlspecialchars($row['username']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td>
                                    <a href="edit-user.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info text-white me-1">✏️ Edit</a>
                                    <a href="hapus-user.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus user ini?')">🗑️ Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada pengguna.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-center mt-3">
        <!-- Tombol Logout yang memicu Modal -->
        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#logoutModal">
            Logout
        </button>
    </div>
</div>

<!-- Modal Konfirmasi Logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        Anda yakin ingin logout?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <a href="logout.php" class="btn btn-danger">Ya, Logout</a>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
