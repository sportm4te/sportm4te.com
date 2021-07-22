@if($errors->isNotEmpty())
    <div class="ms-3 me-3 mb-4 alert alert-small rounded-s shadow-xl bg-red-dark" role="alert">
        <span><i class="fa fa-times color-white"></i></span>
        <strong class="color-white">{{ $errors->first() }}</strong>
        <button type="button" class="close color-white opacity-60 font-16" data-bs-dismiss="alert" aria-label="Close">×</button>
    </div>
@endif
