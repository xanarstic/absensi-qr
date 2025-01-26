<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\LevelModel;
use App\Models\AttendanceModel;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;

class Home extends BaseController
{
	public function index()
	{
		return view('welcome_message');
	}

	public function user()
	{
		$userModel = new UserModel();
		$levelModel = new LevelModel();
		$levels = $levelModel->findAll();

		$data = [
			'users' => $userModel->findAll(),
			'levels' => $levelModel->findAll(),
		];

		echo view('head');
		echo view('menu');
		echo view('user', $data, $levels);
		echo view('foot');
	}

	public function tUser()
	{
		$userModel = new \App\Models\UserModel();

		$data = [
			'username' => $this->request->getPost('username'),
			'id_level' => $this->request->getPost('id_level'),
			'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
		];

		if ($userModel->insert($data)) {
			return redirect()->to('/home/user')->with('success', 'User added successfully!');
		} else {
			return redirect()->to('/home/user')->with('error', 'Failed to add user.');
		}

	}

	public function tLevel()
	{
		$levelModel = new \App\Models\LevelModel();

		$data = [
			'level_name' => $this->request->getPost('level_name'),
		];

		if ($levelModel->insert($data)) {
			return redirect()->to('/home/user')->with('success', 'Level added successfully!');
		} else {
			return redirect()->to('/home/user')->with('error', 'Failed to add level.');
		}

	}

	public function deleteUser($id_user)
	{
		$userModel = new UserModel();
		// Menghapus data user berdasarkan ID
		$userModel->delete($id_user);
		if ($userModel->delete($id_user)) {
			return redirect()->to('/home/user')->with('success', 'User deleted successfully!');
		} else {
			return redirect()->to('/home/user')->with('error', 'Failed to delete user.');
		}

	}

	public function deleteLevel($id_level)
	{
		$levelModel = new LevelModel();
		// Menghapus data level berdasarkan ID
		$levelModel->delete($id_level);
		if ($levelModel->delete($id_level)) {
			return redirect()->to('/home/user')->with('success', 'Level deleted successfully!');
		} else {
			return redirect()->to('/home/user')->with('error', 'Failed to delete level.');
		}

	}

	public function editUser($id_user)
	{
		$userModel = new UserModel();
		$data = [
			'username' => $this->request->getPost('username'),
			'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
			'id_level' => $this->request->getPost('id_level'),
		];
		// Update data user
		$userModel->update($id_user, $data);
		if ($userModel->update($id_user, $data)) {
			return redirect()->to('/home/user')->with('success', 'User updated successfully!');
		} else {
			return redirect()->to('/home/user')->with('error', 'Failed to update user.');
		}

	}

	public function editLevel($id_level)
	{
		$levelModel = new LevelModel();
		$data = [
			'level_name' => $this->request->getPost('level_name'),
		];
		// Update data level
		$levelModel->update($id_level, $data);
		return redirect()->to(base_url('home/user'));
	}

	public function generateQRCode()
	{
		$userModel = new \App\Models\UserModel();

		// Ambil ID user dari request
		$id_user = $this->request->getPost('id_user');

		// Ambil data user berdasarkan ID
		$user = $userModel->find($id_user);

		// Pastikan data user ditemukan
		if ($user) {
			// Tentukan nama file QR Code
			$qrCodeFilename = 'qr_user_' . $id_user . '.png';

			// Generate QR Code
			$qrCode = Builder::create()
				->data($id_user) // Simpan hanya ID user dalam QR code
				->errorCorrectionLevel(new ErrorCorrectionLevelLow())
				->size(300)
				->margin(10)
				->build();

			// Simpan QR Code di folder public/qrcode
			$qrCode->saveToFile(FCPATH . 'qrcode/' . $qrCodeFilename);

			// Update nama file QR Code di database
			$userModel->update($id_user, ['qr_code' => $qrCodeFilename]);

			// Redirect kembali ke halaman user
			return redirect()->to('/home/user')->with('success', 'QR Code generated successfully!');
		} else {
			return redirect()->back()->with('error', 'User not found.');
		}
	}

	public function absen()
	{
		$attendanceModel = new AttendanceModel();
		$attendanceData = $attendanceModel->findAll();

		return view('head')
			. view('menu')
			. view('absen', ['attendanceData' => $attendanceData])
			. view('foot');
	}

	public function saveAttendance()
	{
		$attendanceModel = new AttendanceModel();
		$userModel = new UserModel();

		// Ambil QR code dari request
		$qr_code = $this->request->getVar('qr_code');

		// Cari user berdasarkan ID dari QR code
		$user = $userModel->find($qr_code); // Asumsikan $qr_code berisi ID user langsung

		if ($user) {
			// Ambil data tanggal dan waktu saat ini
			$attendance_date = date('Y-m-d');
			$attendance_time = date('H:i:s');
			$status = 'Present'; // Status absensi

			// Siapkan data untuk disimpan
			$attendanceData = [
				'id_user' => $user['id_user'],
				'attendance_date' => $attendance_date,
				'attendance_time' => $attendance_time,
				'status' => $status
			];

			// Simpan data ke dalam tabel attendance
			if ($attendanceModel->insert($attendanceData)) {
				return $this->response->setJSON(['success' => true]);
			} else {
				return $this->response->setJSON(['success' => false]);
			}
		} else {
			return $this->response->setJSON(['success' => false]);
		}
	}
}
