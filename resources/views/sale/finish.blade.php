@extends('layouts.master')
@section('title')
    Sales Transaction
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Sales Transaction</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check icon"></i>
                    Complete Transaction!
                </div>
                <hr>
                <div>
                    @if ($setting->note_type == 1)
                        <button class="btn btn-info"
                            onclick="smallNote('{{ route('transaction.big_note') }}', 'Note PDF')">Reprint
                            Notes</button>
                    @else
                        <button class="btn btn-info"
                            onclick="bigNote('{{ route('transaction.small_note') }}', 'Small Note')">Reprint Notes</button>
                    @endif
                    <a href="{{ route('transaction.new') }}" class="btn btn-primary">New Transaction</a>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
@endsection


@push('scripts')
    <script type="text/javascript">
        function smallNote(url, title) {
            popupCenter(url, title, 720, 675);
        }

        function bigNote(url, title) {
            popupCenter(url, title, 720, 675);
        }

        function popupCenter(url, title, w, h) => {
            const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screenX;
            const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screenY;

            const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document
                .documentElement.clientWidth : screen.width;
            const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document
                .documentElement.clientHeight : screen.height;

            const systemZoom = width / window.screen.availWidth;
            const left = (width - w) / 2 / systemZoom + dualScreenLeft
            const top = (height - h) / 2 / systemZoom + dualScreenTop
            const newWindow = window.open(url, title,
                `
            scrollbars=yes,
            width=${w / systemZoom}, 
            height=${h / systemZoom}, 
            top=${top}, 
            left=${left}
            `
            )

            if (window.focus) newWindow.focus();
        }
    </script>
@endpush
