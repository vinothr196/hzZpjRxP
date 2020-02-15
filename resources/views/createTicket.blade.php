@extends('layouts.main')
@section('content')
  <!-- Masthead -->
  <header class="masthead text-white text-center">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-xl-9 mx-auto">
          <h1 class="mb-5">Create New Service Request</h1>
        </div>
      </div>
    </div>
  </header>

  <!-- List Tickets -->
  <section class="bg-light">
    <div class="container">
      @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
      <div class="row">
        <form action="#" method="POST">
          @csrf <!-- {{ csrf_field() }} -->
          <fieldset class="form-group">
            <div class="row">
              <legend class="col-form-label">Vehicle's</legend>
              <div class="col-sm-10">
                <div class="form-group">
                  <label class="form-check-label" for="vehicle_make_id">Make</label>
                  <select class="form-control" id="vehicle_make_id" name="vehicle_make_id" required>
                    <option value disabled selected>- Select a Make -</option>
                    @foreach($makes AS $make)
                      <option value="{{ $make->id }}">{{ $make->title }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label class="form-check-label" for="vehicle_model_id">Model</label>
                  <select class="form-control" id="vehicle_model_id" name="vehicle_model_id" required>
                    <option value disabled selected>- Select a Model -</option>
                  </select>
                </div>
              </div>
            </div>
          </fieldset>
          <fieldset class="form-group">
            <div class="row">
              <legend class="col-form-label">Owner's Information</legend>
              <div class="col-sm-10">
                <div class="form-group">
                  <label class="form-check-label" for="client_name">Client Name</label>
                  <input type="text" class="form-control" id="client_name" name="client_name" required>
                </div>
                <div class="form-group">
                  <label class="form-check-label" for="client_phone">Phone</label>
                  <input type="tel" class="form-control" id="client_phone" name="client_phone" placeholder="1234567890" pattern="[0-9]{10}" required>
                </div>
                <div class="form-group">
                  <label class="form-check-label" for="client_email">Email-ID</label>
                  <input type="email" class="form-control" name="client_email" required>
                </div>
              </div>
            </div>
          </fieldset>
          <div class="form-group">
            <label class="form-check-label" for="description">Service Description</label>
            <textarea name="description" class="form-control" rows="4"></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </section>
  <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <script type="text/javascript">
    $('#vehicle_make_id').on('change', function() {
      dropDown = this;
      $('#vehicle_model_id').html(
        '<option value disabled selected>- Select a Model -</option>'
        );
      $.ajax({
            'url':"/getModel/"+dropDown.value,
            'success': function(data) {
              data = JSON.parse(data);
              data.forEach((element) => {
                $('#vehicle_model_id').append(
                  '<option value='+element['id']+'>'+element['title']+'</option>'
                );
              });
            }
          });
      $('#vehicle_model_id').html(htmlData);
    });
  </script>
@endsection