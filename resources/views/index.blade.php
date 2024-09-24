@extends('layouts/main')
@section('body')
<link rel="stylesheet" type="text/css" href="../admin/src/plugins/plyr/dist/plyr.css">
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20 d-flex justify-content-between align-items-center">
            <div class="text-right">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="container mb-30">
                    <div data-type="youtube" data-video-id="d1DndVz9dAs"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="../admin/src/plugins/plyr/dist/plyr.js"></script>
    <script>
		plyr.setup({
			tooltips: {
				controls: !0
			},
		});
	</script>
@endsection
