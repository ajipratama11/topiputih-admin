<div class="container">
    <form action="{{ route('program_public.store') }}" method="POST">
        @csrf
        @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if (Session::has('success'))
        <div class="alert alert-success text-center">
            <p>{{ Session::get('success') }}</p>
        </div>
        @endif
        <table class="table table-bordered" id="dynamicAddRemove">
            <tr>
                <th>Subject</th>
                <th>Action</th>
            </tr>
            <tr>
                <td>
                    <input type="text" name="program_id" placeholder="Enter subject" class="form-control" />
                </td>
                <td>
                    <select name="input[0][user_id]" class="custom-select">
                        @foreach ($user as $name)
                        <option value={{$name->id}}>{{$name->name}}</option>
                        @endforeach
                    </select>
                </td>
                {{-- <td><input type="text" name="input[0][cert_name]" placeholder="Enter subject"
                        class="form-control" />
                </td> --}}
                <td><button type="button" name="add" id="dynamic-ar" class="btn btn-outline-primary">Add
                        Subject</button></td>
            </tr>
        </table>
        <button type="submit" class="btn btn-outline-success btn-block">Save</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script> --}}
<script type="text/javascript">
    var i = 0;
    $("#dynamic-ar").click(function () {
        ++i;
        // $("#dynamicAddRemove").append('<tr><td><input type="text" name="input[' + i +'][cert_name]" placeholder="Enter subject" class="form-control" /></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>'
        //     );
        $("#dynamicAddRemove").append('<tr><td><select name="input[' + i +'][user_id]" class="custom-select" >@foreach ($user as $name)<option value={{$name->id}}>{{$name->name}}</option>@endforeach</select></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>'
        );
    });
    $(document).on('click', '.remove-input-field', function () {
        $(this).parents('tr').remove();
    });
</script>
</div>