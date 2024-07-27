<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <!-- Dropzone CSS -->
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" />

    <title>Mother Link Test</title>
</head>
<body>

<div class="container">

    @include('_partials.header')

    @if(Session::has('message'))
    <div id="message" style="position: relative;" class="alert alert-info mt-5">
        <a class="close" data-dismiss="alert">×</a>
        {{ Session::get('message') }}
    </div>
    @endif

    @yield('content')

    @include('_partials.footer')

</div>

<!-- Optional JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    //Init pusher
    const pusher = new Pusher('6e3b298239585804f384', {
        cluster: 'eu'
    });
    const channel = pusher.subscribe('notification');
    // BInd channel to the event
    channel.bind('import.notification', function(data) {
        next();

        data = JSON.parse(data.message);

        const newText =  'Successfully imported ' + data.total_imported + ' of ' + data.total_count + '. Review the table below for any errors encountered during the import process.';
        $('#importSummeryText').removeClass('d-none').append(newText);

        var tableBody = $('#dynamicTable tbody');
        tableBody.empty(); // Clear existing table rows

        $.each(data.import_statuses, function(index, item) {
            var row = $('<tr>').append(
                $('<td>').text(index).addClass(item === "Import failed" ? 'text-danger' : ''),
                $('<td>').text(item).addClass(item === "Import failed" ? 'text-danger' : '')
            );
            tableBody.append(row);
        });
    });

    //Init Dropzone
    Dropzone.autoDiscover = false;
    const CSRF_TOKEN = $("input[name=_token]").val();
    // Dropzone configuration
    const myDropzone = new Dropzone(".dropzone", {
        url: "{{ route('files.import') }}",
        headers: {
            'x-csrf-token': CSRF_TOKEN,
        },
        paramName: "file",
        maxFilesize: 2, // MB
        maxFiles: 1,
        // acceptedFiles: 'image/*',
        dictDefaultMessage: '<div><i class="bi bi-cloud-arrow-up" style="font-size: 2rem;"></i></div>Drag & drop .csv or .xls/xlsx file here or click to upload here.',
        clickable: true
    });

    //Tabs movement
    let current = 0;
    const tabs = $('.tab');
    const tabs_pill = $('.tab-pills');

    loadFormData(current);

    function loadFormData(n) {
        $(tabs_pill[n]).addClass('active');
        $(tabs[n]).removeClass('d-none');
        $('#back_button').attr('disabled', n === 0);
        $('#next_button').attr('disabled', n === (tabs.length - 1));
    }

    function next() {
        $(tabs[current]).addClass('d-none');
        $(tabs_pill[current]).removeClass('active');

        current++;
        loadFormData(current);
    }

    function back() {
        $(tabs[current]).addClass('d-none');
        $(tabs_pill[current]).removeClass('active');

        current--;
        loadFormData(current);
    }
</script>

</body>
</html>
