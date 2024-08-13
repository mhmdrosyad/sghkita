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
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCheckinModal">
                    <i class="ti ti-plus"></i><span class="ms-1">Add Checkin</span>
                </button>
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
                            <th>Pax</th>
                            <th>Rate</th>
                            <th>Deposit</th>
                            <th>Check-In</th>
                            <th>Check-Out</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($checkins as $checkin)
                        <tr>
                            <td>{{ $checkin->reservation ? $checkin->reservation->order_code : '-' }}</td>
                            <td>{{ $checkin->guest_name }}</td>
                            <td>{{ $checkin->pax }}</td>
                            <td>{{ $checkin->room_charge }}</td>
                            <td>{{ $checkin->deposit }}</td>
                            <td>{{ $checkin->checkin_time }}</td>
                            <td>{{ $checkin->checkout_time }}</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm delete-checkin" data-checkin-id="{{ $checkin->id }}">Delete</button>
                                <form id="delete-form-{{ $checkin->id }}" action="{{ route('checkins.destroy', $checkin->id) }}" method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
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
                            <label for="use_reservation" class="form-label">Use Reservation?</label>
                            <select name="use_reservation" id="use_reservation" class="form-select" required>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>

                        <div class="mb-3" id="reservation_code_container">
                            <label for="order_code" class="form-label">Order Code</label>
                            <select name="order_code" id="order_code" class="form-select">
                                <option value="">Select Order Code</option>
                                @foreach ($activeReservations as $reservation)
                                <option value="{{ $reservation->order_code }}">{{ $reservation->order_code }} - {{ $reservation->customer->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="guest_name" class="form-label">Guest Name</label>
                            <input type="text" name="guest_name" id="guest_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="pax" class="form-label">Pax</label>
                            <input type="number" name="pax" id="pax" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="room_charge" class="form-label">Room Charge</label>
                            <input type="text" name="room_charge" id="room_charge" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="deposit" class="form-label">Deposit</label>
                            <input type="text" name="deposit" id="deposit" class="form-control" required>
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
                $('#checkinTable').DataTable();

                // Handle Delete Button Click
                document.querySelectorAll('.delete-checkin').forEach(button => {
                    button.addEventListener('click', function() {
                        const checkinId = this.getAttribute('data-checkin-id');
                        if (confirm('Are you sure you want to delete this check-in?')) {
                            document.getElementById(`delete-form-${checkinId}`).submit();
                        }
                    });
                });

                // Handle Use Reservation Selection Change
                const useReservationSelect = document.getElementById('use_reservation');
                const reservationCodeContainer = document.getElementById('reservation_code_container');
                const orderCodeSelect = document.getElementById('order_code');
                const guestNameInput = document.getElementById('guest_name');
                const paxInput = document.getElementById('pax');
                const roomChargeInput = document.getElementById('room_charge');
                const depositInput = document.getElementById('deposit');

                useReservationSelect.addEventListener('change', function() {
                    const useReservation = this.value === 'yes';
                    reservationCodeContainer.style.display = useReservation ? 'block' : 'none';
                    orderCodeSelect.required = useReservation;
                    guestNameInput.readOnly = useReservation;
                    paxInput.readOnly = useReservation;
                    roomChargeInput.readOnly = useReservation;
                    depositInput.readOnly = useReservation;

                    if (!useReservation) {
                        // Clear fields if "Use Reservation" is set to "No"
                        orderCodeSelect.value = ''; // Clear the order code value
                        guestNameInput.value = '';
                        paxInput.value = '';
                        roomChargeInput.value = '';
                        depositInput.value = '';
                        document.getElementById('checkin_time').value = '';
                        document.getElementById('checkout_time').value = '';
                    }
                });


                // Handle Order Code Change
                orderCodeSelect.addEventListener('change', function() {
                    const orderCode = this.value;
                    if (orderCode) {
                        fetch(`{{ route('checkins.reservation-data') }}?order_code=${orderCode}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.error) {
                                    alert(data.error);
                                } else {
                                    document.getElementById('guest_name').value = data.guest_name;
                                    document.getElementById('pax').value = data.pax;
                                    document.getElementById('room_charge').value = data.room_charge;
                                    document.getElementById('deposit').value = data.deposit;
                                    document.getElementById('checkin_time').value = data.checkin_time;
                                    document.getElementById('checkout_time').value = data.checkout_time;
                                }
                            });
                    }
                });
            });
        </script>
    </x-slot>
</x-app-layout>