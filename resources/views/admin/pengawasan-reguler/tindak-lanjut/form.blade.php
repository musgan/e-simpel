@php
use Illuminate\Support\Facades\Storage;
$user_level = Auth::user()->user_level;
@endphp
<div class="card mb-3">
    <div class="card-header">
        <h5>Tindak Lanjut</h5>
    </div>
    <div class="card-body">

        @if($user_level->alias == "admin")
            <div class="form-group">
                <label>Status</label>
                <select class="form-control" name="status_pengawasan_regular_id">
                    @foreach($status_pengawasan_regular as $row)
                        <option value="{{$row->id}}" {{($form->status_pengawasan_regular_id == $row->id)?'selected': ''}}> {{$row->nama}}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <div class="form-group">
            <label>Uraian</label>
            <div class="summernote">
                <textarea name="uraian" class="form-control editor" rows="5">{!! $form->uraian !!}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label>evidence</label>
            <input type="file" id="files" class="form-control" name="files" multiple>
        </div>
        @if(count($files) > 0)
            <h5>List File Evidence</h5>
            <ol class="mr-3">
                @foreach($files as $file)
                    <li>
                        <div class="form-check checkbox-lg">
                            <input style="" class="form-check-input checked_file" type="checkbox" value="{{$file}}" name="filechecked[]" checked>
                            <label class="form-check-label" for="flexCheckChecked">
                                <a href="{{asset(Storage::url($file))}}" target="_blank" >  {{basename($file)}} </a>
                            </label>
                        </div>
                    </li>
                @endforeach
            </ol>
        @endif
        <div id="deleted_file"></div>
    </div>
</div>