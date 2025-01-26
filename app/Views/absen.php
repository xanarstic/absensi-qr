<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>
</head>

<body>
    <div class="container">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Attendance</h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#qrScannerModal">
                    Add Attendance
                </button>
            </div>

            <!-- Attendance Table -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>User ID</th>
                            <th>Attendance Date</th>
                            <th>Attendance Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($attendanceData)): ?>
                            <?php foreach ($attendanceData as $key => $row): ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $row['id_user'] ?></td>
                                    <td><?= $row['attendance_date'] ?></td>
                                    <td><?= $row['attendance_time'] ?></td>
                                    <td><?= $row['status'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No attendance records found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- QR Scanner Modal -->
            <div class="modal fade" id="qrScannerModal" tabindex="-1" aria-labelledby="qrScannerModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="qrScannerModalLabel">Scan QR Code</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <video id="cameraStream" autoplay playsinline style="width: 100%;"></video>
                            <canvas id="qrCanvas" hidden></canvas>
                            <button id="startCamera" class="btn btn-success mt-3">Start Camera</button>
                            <button id="stopCamera" class="btn btn-danger mt-3" disabled>Stop Camera</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let videoStream = null;
        let scanningInterval = null;

        const video = document.getElementById('cameraStream');
        const canvas = document.getElementById('qrCanvas');
        const startCameraButton = document.getElementById('startCamera');
        const stopCameraButton = document.getElementById('stopCamera');

        function startCamera() {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then((stream) => {
                    videoStream = stream;
                    video.srcObject = stream;
                    video.play();

                    startCameraButton.disabled = true;
                    stopCameraButton.disabled = false;

                    // Start scanning QR code
                    scanningInterval = setInterval(() => scanQRCode(), 500);
                })
                .catch((error) => {
                    console.error('Error accessing camera:', error);
                });
        }

        function stopCamera() {
            if (videoStream) {
                videoStream.getTracks().forEach((track) => track.stop());
                videoStream = null;
            }

            video.srcObject = null;
            clearInterval(scanningInterval);

            startCameraButton.disabled = false;
            stopCameraButton.disabled = true;
        }

        function scanQRCode() {
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            // Draw video frame to canvas
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Scan for QR code in the canvas
            const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
            const qrCode = jsQR(imageData.data, imageData.width, imageData.height);

            if (qrCode) {
                console.log("QR Code Detected:", qrCode.data);

                // Stop camera and scanning
                stopCamera();

                // Send QR code data to the server
                fetch("<?= site_url('home/saveAttendance') ?>", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: JSON.stringify({ qr_code: qrCode.data })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Attendance recorded successfully!");
                            location.reload(); // Reload page to update table
                        } else {
                            alert("Failed to record attendance.");
                        }
                    })
                    .catch(err => console.error("Error:", err));
            }
        }

        startCameraButton.addEventListener('click', startCamera);
        stopCameraButton.addEventListener('click', stopCamera);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>