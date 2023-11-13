<!DOCTYPE html>
<html>

<head>
    <title>JSON Hierarchy</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
    ul[data-dynamic="true"] .fa-plus {
        color: green;
        margin-left: 5px;
        cursor: pointer;
    }

    ul[data-dynamic="true"] .fa-plus:hover {
        color: darkgreen;
    }

    ul[data-dynamic="true"] .fa-remove {
        color: red;
        margin-left: 5px;
        cursor: pointer;
    }

    ul[data-dynamic="true"] .fa-remove:hover {
        color: darkred;
    }

    ul[data-dynamic="true"] .fa-edit {
        color: darkgreen;
        margin-left: 5px;
        cursor: pointer;
    }

    ul[data-dynamic="true"] .fa-edit:hover {
        color: darken(yellow, 20%);
    }

    ul.list-group {
        padding: 10px;
        background: gainsboro;
        list-style: none;
        transition: all 500ms;
    }

    ul.list-group .list-group-item {
        transition: all 500ms;
    }

    ul.list-group .list-group-item a {
        padding: 5px 0;
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    ul.list-group .list-group-item:hover {
        background: gainsboro;
    }

    button.fa-save {

        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        display: block;
        margin-left: auto;
        margin-right: 50px;
        font-size: 16px;
    }

    /* CSS */
    .highlight {
        background-color: green;
        /* Change this to your preferred highlight color */
    }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <button type="button" disabled class="fa fa-plus">Add</button>
    <button type="button" disabled class="fa fa-remove">Delete</button>
    <input type="text" disabled name="Levels List" value="Levels List" placeholder="index_name">
    <form method="POST" action="{{ url('updateJson') }}" id="formnodes" name="formnodes">
        <input type="hidden" name="level_key" value="{{ $level_key }}">
        @csrf
        @component('componentJson', ['data' => $data, 'name' => '', 'level_key' => $level_key])
        @endcomponent
        <button type="submit" class="fa fa-save btn-primary float-right">Save</button>
    </form>
    <hr>
    <hr>
    <hr>
    <div class="card">
        <div class="card-header text-center">
            Pages
        </div>
        <ul class="list-group list-group-horizontal d-flex justify-content-center">
            @foreach($levelIndexes as $l)
            <li class="list-group-item"><a url="{{route('read2', ['level' => $l]) }}" class="index-link"
                    data-index="{{$l}}">{{$l}}</a></li>
            @endforeach
        </ul>
        <div class="card-footer text-center">
            <button type="button" class="btn btn-primary" id="showMore">Show More</button>
        </div>
    </div>


    <script>
    $(document).ready(function() {
        var counter = 0;

        $('ul[data-dynamic="true"]').on('click', 'button.fa-plus', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var $li = $(this).closest('li');
            var $ul = $li.find('ul');
            var parentKeyName = $li.find('input[type="text"][placeholder="index_name"]').attr('name');
            var parentValueName = $li.find('input[type="text"][placeholder="index_value"]').attr(
                'name');
            if (!$ul.length) {
                $ul = $('<ul data-dynamic="true"></ul>');
                $li.append($ul);
            }
            var newKey = 'new_key' + counter++;
            var indexNameInput =
                `<input type="text" name="${parentKeyName}[${newKey}]" value="" placeholder="index_name" oninput="this.nextElementSibling.setAttribute('name', '${parentValueName}[' + this.value + ']')">`;
            var indexValueInput =
                `<input type="text" name="${parentValueName}[${newKey}]" value="" placeholder="index_value">`;
            $ul.append(`
            <li class="list-group-item">
                <div>
                    <button type="button" class="fa fa-plus">Add</button>
                    <button type="button" class="fa fa-remove">Delete</button>
                    ${indexNameInput}
                    ${indexValueInput}
                    
                </div>
            </li>
        `);
        });

        $('ul[data-dynamic="true"]').on('click', 'button.fa-remove', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            if (confirm('Are you sure you want to delete this node?')) {
                $(this).closest('li').remove();
            }
        });
    });


    $(document).ready(function() {
        $(".index-link:gt(9)").hide();


        $("#showMore").click(function() {
            $(".index-link").show();
            $(this).hide();
        });
    });


    // JavaScript
    window.onload = function() {
        let prevLik = localStorage.getItem('selectedLink');
        var links = document.querySelectorAll('.index-link');
        links.forEach(function(link) {
            link.addEventListener('click', function() {
                localStorage.setItem('selectedLink', this.getAttribute('data-index'));
                var formData = $("form[name='formnodes']").not('.deleted').serialize();

                putSession(prevLik, formData, this.getAttribute(
                    'url'));
                console.log(prevLik);
                // return;
            });
            if (localStorage.getItem('selectedLink') === link.getAttribute('data-index')) {
                link.classList.add('highlight');
            }
        });
        if (!localStorage.getItem('selectedLink')) {
            document.querySelector('.index-link[data-index="1"]').classList.add('highlight');
        }
    }

    function putSession(index, data, rout) {
        $.ajax({
            url: '/sessionSetData/' + index,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            success: function(response) {
                window.location.href = rout;
                $("form[name='formnodes']").reset();
                clearjQueryCache();

            }
        });
    }
    </script>



</body>

</html>