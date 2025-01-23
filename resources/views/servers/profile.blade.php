@extends('servers.layouts.app')

@section('seoMeta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{ auth()->user()->media ? auth()->user()->media->cloudinary_url : asset('img/no_photo.svg') }}"
                                alt="User profile picture" onclick="openProfilePicturePopup()"> <!-- Tambahkan onclick -->
                        </div>

                        <h3 class="profile-username text-center">{{ auth()->user()->name }}</h3>
                        {{-- <p class="text-muted text-center">{{ auth()->user()->role->name }}</p> --}}
                    </div>
                </div>

                <!-- Modal Popup -->
                <div id="profilePicturePopup" class="modal fade" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Profile Picture</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <button class="btn btn-primary btn-block" onclick="showFileInput()">Change Picture</button>
                                <button class="btn btn-danger btn-block" onclick="removeProfilePicture()">Remove
                                    Picture</button>
                                <button class="btn btn-secondary btn-block"
                                    onclick="closeProfilePicturePopup()">Cancel</button>

                                <!-- Form Input File (Sembunyi pada awalnya) -->
                                <div id="fileInputContainer" style="display: none; margin-top: 10px;">
                                    <div class="custom-file">
                                        <input type="file" id="profilePictureInput" accept="image/*"
                                            class="custom-file-input">
                                        <label class="custom-file-label" for="profilePictureInput">Choose
                                            file</label>
                                    </div>
                                    <button onclick="uploadProfilePicture()" class="btn btn-success btn-block"
                                        style="margin-top: 10px;">
                                        Upload
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a>
                            </li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- /.tab-pane -->
                            <div class="active tab-pane" id="settings">
                                <form action="{{ route('profile.update', auth()->user()->id) }}" method="POST"
                                    class="form-horizontal">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="inputName" name="name" value="{{ auth()->user()->name }}">
                                        </div>

                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                id="inputEmail" name="email" value="{{ auth()->user()->email }}">
                                        </div>

                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10 input-group">
                                            <input type="password" name="password"
                                                class="form-control @error('password') is-invalid @enderror" id="password"
                                                placeholder="Enter your password">
                                            <button class="btn btn-secondary" type="button" id="togglePassword">
                                                <i class="fas fa-eye" id="toggleIcon"></i>
                                            </button>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-danger">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- bs-custom-file-input -->
    <script src="https://adminlte.io/themes/v3/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

    <script>
        function openProfilePicturePopup() {
            // Membuka modal Bootstrap
            $('#profilePicturePopup').modal('show');
        }

        function closeProfilePicturePopup() {
            // Menutup modal Bootstrap
            $('#profilePicturePopup').modal('hide');

            // Reset elemen input file dan container-nya
            const fileInputContainer = document.getElementById("fileInputContainer");
            const fileInput = document.getElementById("profilePictureInput");

            // Sembunyikan container input file
            fileInputContainer.style.display = "none";

            // Reset nilai input file
            fileInput.value = "";
        }

        function showFileInput() {
            // Menampilkan input file di dalam modal
            document.getElementById("fileInputContainer").style.display = "block";
        }

        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            // Toggle the type attribute
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        });

        // Fungsi untuk membuka form input file saat tombol "Change Picture" diklik
        function showFileInput() {
            document.getElementById("fileInputContainer").style.display = "block"; // Menampilkan input file
        }
    </script>

    <script>
        // Fungsi untuk mengupload gambar profil
        function uploadProfilePicture() {
            const fileInput = document.getElementById("profilePictureInput");
            const uploadButton = document.querySelector("button[onclick='uploadProfilePicture()']");
            const file = fileInput.files[0];

            // Menonaktifkan tombol "Upload" dan menutup pop-up saat upload dimulai
            uploadButton.disabled = true; // Menonaktifkan tombol upload
            closeProfilePicturePopup(); // Menutup pop-up segera setelah tombol "Upload" diklik

            if (file) {
                // Menampilkan SweetAlert yang menunjukkan proses upload
                Swal.fire({
                    title: 'Sedang mengupload image profile...',
                    text: 'Harap tunggu beberapa saat.',
                    icon: 'info',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading(); // Menampilkan indikator loading
                    }
                });

                const formData = new FormData();
                formData.append("profile_image", file); // Sesuaikan nama field dengan controller
                formData.append("_method", "PUT"); // Laravel membutuhkan metode PUT
                formData.append("_token", document.querySelector('meta[name="csrf-token"]').content); // CSRF token

                const url = "{{ route('profile.update', auth()->user()->id) }}"; // Route untuk update

                fetch(url, {
                        method: "POST", // Gunakan POST karena PUT dikirim dengan "_method"
                        body: formData,
                    })
                    .then(response => {
                        if (response.ok) {
                            return response.json();
                        } else {
                            throw new Error("Upload failed");
                        }
                    })
                    .then(data => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Gambar profil berhasil di-upload.',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload(); // Refresh halaman setelah notifikasi ditutup
                        });
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan saat mengupload gambar.',
                        });
                        console.error(error);
                    })
                    .finally(() => {
                        uploadButton.disabled = false; // Mengaktifkan kembali tombol upload
                    });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Gambar',
                    text: 'Harap pilih gambar terlebih dahulu.',
                });
                uploadButton.disabled = false; // Mengaktifkan kembali tombol upload jika file tidak dipilih
            }
        }
    </script>

    <script>
        function removeProfilePicture() {
            // Konfirmasi sebelum menghapus
            Swal.fire({
                title: 'Yakin ingin menghapus foto profil?',
                text: "Tindakan ini tidak dapat dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Menampilkan SweetAlert yang menunjukkan proses upload
                    Swal.fire({
                        title: 'Sedang menghapus image profile...',
                        text: 'Harap tunggu beberapa saat.',
                        icon: 'info',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading(); // Menampilkan indikator loading
                        }
                    });

                    const url = "{{ route('profile.destroy', auth()->user()->id) }}"; // Route untuk destroy
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                    fetch(url, {
                            method: "DELETE", // Gunakan metode DELETE
                            headers: {
                                "X-CSRF-TOKEN": csrfToken // CSRF token
                            }
                        })
                        .then(response => {
                            if (response.ok) {
                                return response.json();
                            } else {
                                return response.json().then(error => {
                                    throw new Error(error.error || "Failed to remove profile picture");
                                });
                            }
                        })
                        .then(data => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Foto profil berhasil dihapus.',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload(); // Refresh halaman setelah berhasil
                            });
                        })
                        .catch(error => {
                            console.error(error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: error.message || 'Terjadi kesalahan saat menghapus foto profil.',
                            });
                        });
                }
            });
        }
    </script>
@endsection
