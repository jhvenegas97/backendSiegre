<style>
    .body-class {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
        background-color: #f7f8fc;
        font-family: "Roboto", sans-serif;
        color: #10182f;
    }

    .container-class {
        display: flex;
        width: 100%;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
    }

    .card-class {
        margin: 10px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        width: 380px;
    }
</style>

<div class="container-class">
    @if (count($usersCurriculum) >= 1)
        @foreach ($usersCurriculum as $key => $userCurriculum)
            <div class="card-class">
                <div class="p-4">
                    <div class=" image d-flex flex-column justify-content-center align-items-center">
                        <button class="btn btn-new show" data-id="{{$userCurriculum->id}}">
                            @if ($userCurriculum->avatar != null)
                                <img src="{{ $userCurriculum->avatar }}" width="100" height="100"
                                    class="img-responsive img-circle" alt="">
                            @else
                                @if ($userCurriculum->fileName != null)
                                    <img src="{{ asset('uploads/' . $userCurriculum->fileName) }}" width="100"
                                        height="100" class="img-responsive img-circle" alt="">
                                @else
                                    <img src="{{ asset('images/admin.svg') }}" width="100" height="100"
                                        class="img-responsive img-circle" alt="">
                                @endif
                            @endif
                        </button> <span class="name mt-3 fw-bold">{{ $userCurriculum->name }}</span> <span
                            class="idd">{{ $userCurriculum->email }}</span>
                        <div class="text mt-3"> <span>Eleanor Pena is a creator of minimalistic x bold graphics and
                                digital
                                artwork.<br><br> Artist/ Creative Director by Day #NFT minting@ with FND night. </span>
                        </div>
                        <div class="gap-3 mt-3 icons d-flex flex-row justify-content-center align-items-center">
                            <span><i class="fa fa-twitter"></i></span> <span><i class="fa fa-facebook-f"></i></span>
                            <span><i class="fa fa-instagram"></i></span> <span><i class="fa fa-linkedin"></i></span>
                        </div>
                        <div class=" px-2 rounded mt-4 date "> <span class="join">Joined May,2021</span> </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <h3 class="text-center">No se encontraron resultados</h3>
    @endif

</div>
<div id="pagination" class="d-flex justify-content-center mt-3">
    {{ $usersCurriculum->links() }}
</div>

<script>
    $('body').on('click', '.show', function (e) {
                //e.preventDefault();
                var id = $(this).data('id');
                // ajax
                $.ajax({
                    type:"GET",
                    url: "{{ url('curriculum') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                    }
                });
            });
</script>