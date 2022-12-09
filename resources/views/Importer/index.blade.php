<html>
    <body>
    <h1>New upload</h1>
        <form method="POST" enctype="multipart/form-data">
            Upload work orders: <input type="file" name="workorders" /><br />
            <input type="submit" name="upload" value="Upload">
        </form>
        <br /><hr /><br/>
        <h1>Previous uploads:</h1>
        @if (count($list) == 0)
            No uploads.
        @else
            @foreach($list as $upload)
                {{ $upload->run_at }}
            @endforeach
        @endif
    </body>
</html>