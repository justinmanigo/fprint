<div id="printing_schedule" class="container my-5 mb-6">
    <div id="printing_schedule_card" class="row p-4 pb-0 pe-lg-0 pt-lg-5 align-items-center rounded-3 border shadow-lg">
        <div id="printing_schedule_text" class="col-lg-7 p-3 p-lg-5 pt-lg-3">
            <h2  id="font1" class="display-4 fw-bold lh-1">Printing Schedule</h2>
            <p id="font1" class="lead">
                Monday to Friday<br>
                8:00 am - 4:00 pm
            </p>

            <div id="font1" class="d-grid gap-2 d-md-flex justify-content-md-start mb-4 mb-lg-3">
                @guest
                    <a href="{{ route('register') }}" role="button" class="btn btn-light btn-lg px-4 me-md-2 fw-bold">Start Reserving Yours Now</a>
                @endguest
            </div>
        </div>
        <div class="col-lg-4 offset-lg-1 p-0 overflow-hidden shadow-lg">
            {{-- Insert picture here later :)) --}}
            {{-- <img class="rounded-lg-3" src="bootstrap-docs.png" alt="" width="720"> --}}
        </div>
    </div>
</div>