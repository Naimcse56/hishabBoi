@extends('layouts.install')
@section('content')
    <div class="container pt-5">
        <div class="d-flex justify-content-center mt-5">
            <div class="card  position-relative">
                <!-- Content -->
                <div class="card-body -body h-100 w-100 z-3 position-relative">
                    <!-- Top content -->
                    <div class="mar-ver pad-btm text-center">
                        <h1 class="fs-21 fw-700 text-uppercase mt-2" style="color: #3d3d3d;">MIGRATE DATABASE</h1>
                        <p class="fs-12 fw-500" style="color:  #666; line-height: 18px;">
                            Your database is successfully connected. All you need to do now is hit the ‘Install’ Button. The auto installer will run a sql file, will do all the tiresome works and set up your application automatically.
                        </p>
                    </div>
                    
                    <div class="mb-4 pb-4 absolute-bottom-left right-0 d-flex justify-content-center">
                      {{-- <a href="{{ route('import_sql') }}" class="btn btn-primary text-uppercase" onclick="showLoder()">MIGRATE DATABASE</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        function showLoder() {
            $('#loader').fadeIn();
        }
    </script>
@endsection
