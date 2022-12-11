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
            <table><thead><th>Run at</th><th>Entries processed</th><th>Entries created</th></thead>
            @foreach($list as $upload)
                    <td><a href="{{ Storage::url('reports/'.$upload->id.'.csv') }}">{{ $upload->run_at }}</a></td><td>{{ $upload->entries_processed }}</td><td>{{ $upload->entries_created }}</td></tr>
            @endforeach
            </table>
        @endif
    </body>
</html>