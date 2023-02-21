<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
@vite('resources/css/app.css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.0.2/tailwind.min.css" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>function showPopover() {
        document.getElementById("popover").classList.toggle("hidden");
    }
    function showPopover_cancel() {
        document.getElementById("popover_cancel").classList.toggle("hidden");
    }
    function showPopoverID(id) {
        document.getElementById("popover_"+id).classList.toggle("hidden");
    }
    function showPopover_cancelID(id) {
        document.getElementById("popover_cancel_"+id).classList.toggle("hidden");
    }
</script>
<title>{{$title ?? 'BoardGames'}}</title>
