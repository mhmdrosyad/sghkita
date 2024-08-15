<x-app-layout>
    <div class="title-wrapper pt-30">

    </div>

    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-bolder">History Check-Out</h4>
                <a href="{{ route('checkins.index') }}" class="btn btn-primary mb-3">
                    <i class="ti ti-arrow-left"></i><span class="ms-1">Back</span>
                </a>
            </div>
        </div>
        <!-- Check-Out Table -->
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
                            <th>Status</th>
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
                                <span class="badge bg-danger" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">Check-Out</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <x-slot name="scripts">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                $('#checkinTable').DataTable();
            });
        </script>
    </x-slot>

</x-app-layout>