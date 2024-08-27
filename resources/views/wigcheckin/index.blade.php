<x-app-layout>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <div class="title-wrapper pt-30">
        <h4 class="fw-bolder">Daftar Check-In Wig</h4>
    </div>

    <!-- Tabel Daftar Check-In -->
    <div class="card mb-4">
        <div class="card-body">
            <!-- Button to Open the Modal -->
            <div class="d-flex justify-content-between align-items-right mb-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCheckinModal">
                    <i class="ti ti-plus"></i><span class="ms-1">Tambah Check-In</span>
                </button>
            </div>
            <div class="table-wrapper table-responsive">
                <table id="WigCheckinTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Check-In Code</th>
                            <th>Guest Name</th>
                            <th>Room</th>
                            <th>Rate</th>
                            <th>Check-In Time</th>
                            <th>Check-Out Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($wigcheckins as $wigcheckin)
                        <tr>
                            <td>{{ $wigcheckin->checkin_code }}</td>
                            <td>{{ $wigcheckin->guest_name }}</td>
                            <td class="text-center">{{ $wigcheckin->room }}</td>
                            <td>Rp.{{ number_format($wigcheckin->rate, 0, ',', '.') }}</td>
                            <td>{{ $wigcheckin->checkin_time->format('d-m-Y H:i') }}</td>
                            <td>{{ $wigcheckin->checkout_time ? $wigcheckin->checkout_time->format('d-m-Y H:i') : '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $wigcheckin->status === 'checkin' ? 'success' : 'danger' }}">
                                    {{ ucfirst($wigcheckin->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Check-In -->
    <div class="modal fade" id="addCheckinModal" tabindex="-1" aria-labelledby="addCheckinModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addCheckinForm" action="{{ route('wigcheckins.store') }}" method="POST">
                    @csrf
                    <div class="modal-header text-white bg-primary">
                        <h5 class="modal-title" id="addCheckinModalLabel">
                            <i class="ti ti-user-plus"></i> Tambah Check-In
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="guest_name" class="form-label">Nama Tamu</label>
                            <input type="text" class="form-control" id="guest_name" name="guest_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="room" class="form-label">Room</label>
                            <input type="text" class="form-control" id="room" name="room" required>
                        </div>
                        <div class="mb-3">
                            <label for="rate" class="form-label">Rate</label>
                            <input type="number" class="form-control" id="rate" name="rate" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="checkin_time" class="form-label">Waktu Check-In</label>
                            <input type="datetime-local" class="form-control" id="checkin_time" name="checkin_time" required>
                        </div>
                        <div class="mb-3">
                            <label for="checkout_time" class="form-label">Waktu Check-Out</label>
                            <input type="datetime-local" class="form-control" id="checkout_time" name="checkout_time">
                        </div>
                        <div class="mb-3">
                            <!-- Status tidak diperlukan karena default 'checkin' sudah diatur di controller -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="ti ti-close"></i> Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-save"></i> Save Check-In
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <x-slot name="scripts">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize DataTable
                $('#WigCheckinTable').DataTable();
            });
        </script>
    </x-slot>
</x-app-layout>