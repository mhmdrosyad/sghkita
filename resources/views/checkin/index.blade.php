<x-app-layout>
    <div class="title-wrapper pt-30">
    </div>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-bolder">Daftar Checkin</h4>
                <div>
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCheckinModal">
                        <i class="ti ti-plus"></i><span cla ss="ms-1">Add Checkin</span>
                    </button>
                    <a href="{{ route('checkins.history') }}" class="btn btn-secondary mb-3 ms-2">
                        <i class="lni lni-history"></i><span class="ms-1">History</span>
                    </a>

                </div>
            </div>
        </div>

        <!-- Check-In Table -->
        <div class="card-body">
            <div class="table-wrapper table-responsive">
                <table id="checkinTable" class="table striped-table">
                    <thead>
                        <tr>
                            <th>Order Code</th>
                            <th>Nama</th>
                            <th>Instansi</th>
                            <th>Tagihan</th>
                            <th>Check-In</th>
                            <th>Check-Out</th>
                            <th>Status</th> <!-- Updated header -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($checkins as $checkin)
                        <tr>
                            <td>{{ $checkin->reservation ? $checkin->reservation->order_code : '-' }}</td>
                            <td>{{ $checkin->guest_name }}</td>
                            <td>{{ $checkin->instansi }}</td>
                            <td>{{ number_format($checkin->total_tagihan, 0, ',', '.') }}</td>
                            <td>{{ $checkin->checkin_time }}</td>
                            <td>{{ $checkin->checkout_time }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if ($checkin->status === 'checkin')
                                    <span class="badge bg-success me-2" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">Check-In</span>
                                    <button type="button" class="btn btn-warning btn-sm btn-icon change-status"
                                        data-checkin-id="{{ $checkin->id }}"
                                        data-new-status="checkout"
                                        style="font-size: 0.75rem; padding: 0.2rem 0.5rem; border: none; background: none; color: inherit; display: flex; align-items: center;">
                                        <i class="lni lni-arrow-right" style="font-size: 1rem; color: white; background-color: red; border-radius: 50%; padding: 0.25rem;"></i>
                                    </button>
                                    @else
                                    <span class="badge bg-danger" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">Check-Out</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for Adding Check-In -->
    <div class="modal fade" id="addCheckinModal" tabindex="-1" aria-labelledby="addCheckinModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="checkinForm" action="{{ route('checkins.store') }}" method="POST">
                    @csrf
                    <div class="modal-header text-white">
                        <h5 class="modal-title" id="addCheckinModalLabel">
                            <i class="ti ti-user-plus"></i> Add Check-In
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="order_code" class="form-label">Order Code</label>
                            <select name="order_code" id="order_code" class="form-select" required>
                                <option value="">Select Order Code</option>
                                @foreach ($activeReservations as $reservation)
                                <option value="{{ $reservation->order_code }}">{{ $reservation->order_code }} - {{ $reservation->customer->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="guest_name" class="form-label">Guest Name</label>
                            <input type="text" name="guest_name" id="guest_name" class="form-control" readonly required>
                        </div>
                        <div class="mb-3">
                            <label for="instansi" class="form-label">Instansi</label>
                            <input type="text" name="instansi" id="instansi" class="form-control" readonly required>
                        </div>
                        <div class="mb-3">
                            <label for="total_tagihan" class="form-label">Total Tagihan</label>
                            <input type="text" name="total_tagihan" id="total_tagihan" class="form-control" readonly required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="checkin_time" class="form-label">Check-In Time</label>
                                <input type="datetime-local" name="checkin_time" id="checkin_time" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="checkout_time" class="form-label">Check-Out Time</label>
                                <input type="datetime-local" name="checkout_time" id="checkout_time" class="form-control" required>
                            </div>
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
                const table = $('#checkinTable').DataTable();

                // Handle order code selection
                const orderCodeSelect = document.getElementById('order_code');
                const guestNameInput = document.getElementById('guest_name');
                const instansiInput = document.getElementById('instansi');
                const totalTagihanInput = document.getElementById('total_tagihan');
                const checkinTimeInput = document.getElementById('checkin_time');
                const checkoutTimeInput = document.getElementById('checkout_time');

                orderCodeSelect.addEventListener('change', function() {
                    const orderCode = this.value;

                    if (orderCode) {
                        fetch(`{{ route('checkins.reservation-data') }}?order_code=${orderCode}`, {
                                method: 'GET',
                                headers: {
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.error) {
                                    alert(data.error);
                                } else {
                                    guestNameInput.value = data.guest_name || '';
                                    instansiInput.value = data.instansi || '';
                                    totalTagihanInput.value = data.total_tagihan || '';
                                    checkinTimeInput.value = data.checkin_time || '';
                                    checkoutTimeInput.value = data.checkout_time || '';
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                            });
                    } else {
                        // Clear fields if no order code is selected
                        guestNameInput.value = '';
                        instansiInput.value = '';
                        totalTagihanInput.value = '';
                        checkinTimeInput.value = '';
                        checkoutTimeInput.value = '';
                    }
                });

                // Handle check-in/check-out status change
                document.querySelectorAll('.change-status').forEach(button => {
                    button.addEventListener('click', function() {
                        const checkinId = this.getAttribute('data-checkin-id');
                        const newStatus = this.getAttribute('data-new-status');
                        const statusText = newStatus === 'checkout' ? 'Check-Out' : 'Check-In';

                        if (confirm(`Are you sure you want to ${statusText} now?`)) {
                            fetch(`{{ route('checkins.update-status') }}`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                    },
                                    body: JSON.stringify({
                                        checkin_id: checkinId,
                                        status: newStatus
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        location.reload(); // Refresh the page to see the updated status
                                    } else {
                                        alert('Error updating status');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                });
                        }
                    });
                });

            });
        </script>
    </x-slot>
</x-app-layout>