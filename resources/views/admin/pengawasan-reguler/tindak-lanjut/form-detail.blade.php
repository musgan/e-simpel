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
                <div class="form-control h-auto" readonly="">
                    {{$form->statuspengawasanregular->nama}}
                </div>
            </div>
        @endif
        <div class="form-group">
            <label>Tanggal tindak lanjut</label>
            <div class="form-control h-auto" readonly="">{{\App\Helpers\CostumHelpers::getDateDMY($form->tanggal_tindak_lanjut)}}</div>
        </div>
        <div class="form-group">
            <label>Uraian</label>
            <div class="summernote">
                <div class="form-control h-auto" readonly="">{!! $form->uraian !!}</div>
            </div>
        </div>
        <div class="form-group">
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
        </div>
    </div>
</div>