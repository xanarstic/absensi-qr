<div aria-live="polite" aria-atomic="true" class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="toastNotification" class="toast" role="alert" aria-live="assertive" aria-atomic="true"
        data-bs-autohide="true">
        <div class="toast-header">
            <strong class="me-auto">Notification</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <!-- Pesan akan diisi melalui script -->
        </div>
    </div>
</div>
<div class="d-flex">
    <div class="container-fluid" style="margin-left: 250px;">
        <div class="row mt-4">
            <!-- Users Table -->
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Users</h4>
                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#addUserModal">
                        <i class="bi bi-plus-circle"></i> Add
                    </button>
                </div>
                <table class="table table-bordered table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>ID Level</th>
                            <th>QR Code</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= esc($user['id_user']); ?></td>
                                    <td><?= esc($user['username']); ?></td>
                                    <td><?= esc($user['id_level']); ?></td>
                                    <td>
                                        <?php if (!empty($user['qr_code'])): ?>
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#qrCodeModal"
                                                data-qr="<?= base_url('qrcode/' . esc($user['qr_code'])); ?>">
                                                View QR Code
                                            </button>
                                        <?php else: ?>
                                            Not Generated
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($user['created_at']); ?></td>
                                    <td>
                                        <!-- Generate QR Code Button -->
                                        <form action="<?= base_url('home/generateQRCode'); ?>" method="post" class="d-inline">
                                            <input type="hidden" name="id_user" value="<?= esc($user['id_user']); ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-qr-code"></i> Generate
                                            </button>
                                        </form>
                                        <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal"
                                            data-bs-target="#editUserModal" data-id="<?= esc($user['id_user']); ?>"
                                            data-username="<?= esc($user['username']); ?>"
                                            data-idlevel="<?= esc($user['id_level']); ?>">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"
                                            onclick="setDeleteUrl('<?= esc($user['id_user']); ?>')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No users found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Modal untuk Konfirmasi Delete -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this user?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Yes, Delete</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Levels Table -->
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Levels</h4>
                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#addLevelModal">
                        <i class="bi bi-plus-circle"></i> Add
                    </button>
                </div>
                <table class="table table-bordered table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Level Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($levels)): ?>
                            <?php foreach ($levels as $level): ?>
                                <tr>
                                    <td><?= esc($level['id_level']); ?></td>
                                    <td><?= esc($level['level_name']); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal"
                                            data-bs-target="#editLevelModal" data-id="<?= esc($level['id_level']); ?>"
                                            data-levelname="<?= esc($level['level_name']); ?>">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteLevelModal"
                                            onclick="setDeleteLevelUrl('<?= esc($level['id_level']); ?>')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">No levels found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Modal untuk Konfirmasi Delete Level -->
            <div class="modal fade" id="deleteLevelModal" tabindex="-1" aria-labelledby="deleteLevelModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteLevelModalLabel">Delete Level Confirmation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this level?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteLevelBtn">Yes, Delete</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pop-Up Modal for Add User -->
            <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-dark text-white">
                            <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?= base_url('home/tUser'); ?>" method="post">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" name="username" id="username" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="id_level" class="form-label">Select Level</label>
                                    <select name="id_level" id="id_level" class="form-select" required>
                                        <option value="" disabled selected>Choose Level</option>
                                        <?php if (!empty($levels)): ?>
                                            <?php foreach ($levels as $level): ?>
                                                <option value="<?= esc($level['id_level']); ?>">
                                                    <?= esc($level['level_name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option value="" disabled>No levels available</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- buat level pop up -->
            <div class="modal fade" id="addLevelModal" tabindex="-1" aria-labelledby="addLevelModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-dark text-white">
                            <h5 class="modal-title" id="addUserModalLabel">Add Level</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?= base_url('home/tLevel'); ?>" method="post">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="level_name" class="form-label">Level Name</label>
                                    <input type="text" name="level_name" id="level_name" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal QR Code View -->
            <div class="modal fade" id="qrCodeModal" tabindex="-1" aria-labelledby="qrCodeModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="qrCodeModalLabel">QR Code</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img id="qrCodeImage" src="" alt="QR Code" class="img-fluid">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for Edit User -->
            <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-dark text-white">
                            <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?= base_url('home/editUser'); ?>" method="post">
                            <input type="hidden" name="id_user" id="editUserId">
                            <div class="mb-3">
                                <label for="editUsername" class="form-label">Username</label>
                                <input type="text" name="username" id="editUsername" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="editPassword" class="form-label">Password</label>
                                <input type="password" name="password" id="editPassword" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="editIdLevel" class="form-label">Select Level</label>
                                <select name="id_level" id="editIdLevel" class="form-select" required>
                                    <option value="" disabled selected>Choose Level</option>
                                    <?php foreach ($levels as $level): ?>
                                        <option value="<?= esc($level['id_level']); ?>"><?= esc($level['level_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal for Edit Level -->
            <div class="modal fade" id="editLevelModal" tabindex="-1" aria-labelledby="editLevelModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-dark text-white">
                            <h5 class="modal-title" id="editLevelModalLabel">Edit Level</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?= base_url('home/editLevel'); ?>" method="post">
                            <input type="hidden" name="id_level" id="editLevelId">
                            <div class="mb-3">
                                <label for="editLevelName" class="form-label">Level Name</label>
                                <input type="text" name="level_name" id="editLevelName" class="form-control" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // Ambil modal dan gambar untuk QR Code
    var qrCodeModal = document.getElementById('qrCodeModal');
    var qrCodeImage = document.getElementById('qrCodeImage');

    qrCodeModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Tombol yang dipencet
        var qrUrl = button.getAttribute('data-qr'); // Ambil URL QR dari data-bs-qr

        // Set gambar QR Code ke modal
        qrCodeImage.src = qrUrl;
    });
</script>
<script>
    // Mengisi modal Edit User
    $('#editUserModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Tombol yang memicu modal
        var id_user = button.data('id_user'); // Ambil data-id dari tombol
        var username = button.data('username'); // Ambil data-username
        var id_level = button.data('id_level'); // Ambil data-idlevel

        // Isi form di dalam modal dengan data yang diambil
        var modal = $(this);
        modal.find('#editUserId').val(id_user);
        modal.find('#editUsername').val(username);
        modal.find('#editPassword').val(''); // Kosongkan password karena harus diisi ulang
        modal.find('#editIdLevel').val(id_level);
    });


    // Mengisi modal Edit Level
    $('#editLevelModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Tombol yang memicu modal
        var id_level = button.data('id_level'); // Ambil data-id
        var level_name = button.data('level_name'); // Ambil data-levelname

        // Isi form di dalam modal dengan data yang diambil
        var modal = $(this);
        modal.find('#editLevelId').val(id_level);
        modal.find('#editLevelName').val(level_name);
    });

</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        <?php if (session()->getFlashdata('success')): ?>
            var toastElement = document.getElementById('toastNotification');
            var toast = new bootstrap.Toast(toastElement);
            toastElement.querySelector('.toast-body').innerText = "<?= session()->getFlashdata('success'); ?>";
            toast.show();
        <?php elseif (session()->getFlashdata('error')): ?>
            var toastElement = document.getElementById('toastNotification');
            var toast = new bootstrap.Toast(toastElement);
            toastElement.querySelector('.toast-body').innerText = "<?= session()->getFlashdata('error'); ?>";
            toast.show();
        <?php endif; ?>
    });
</script>
<script>
    var deleteUrl = "";

    // Fungsi untuk menyimpan URL yang akan dihapus
    function setDeleteUrl(id) {
        deleteUrl = "<?= base_url('home/deleteUser/'); ?>" + id;
    }

    // Ketika tombol "Yes, Delete" diklik, lakukan penghapusan
    document.getElementById("confirmDeleteBtn").addEventListener("click", function () {
        // Pindahkan ke URL penghapusan
        window.location.href = deleteUrl;
    });
</script>
<script>
    var deleteLevelUrl = "";

    // Fungsi untuk menyimpan URL yang akan dihapus untuk level
    function setDeleteLevelUrl(id) {
        deleteLevelUrl = "<?= base_url('home/deleteLevel/'); ?>" + id;
    }

    // Ketika tombol "Yes, Delete" diklik, lakukan penghapusan level
    document.getElementById("confirmDeleteLevelBtn").addEventListener("click", function () {
        // Pindahkan ke URL penghapusan level
        window.location.href = deleteLevelUrl;
    });
</script>