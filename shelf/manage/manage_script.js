
// When user click anywhere of the row of a single file, the check box
// will be set to checked. This causes that when user click the check box,
// the check box is then unchecked. Hence reverse the check box's result
// again by this function.
function set_check_box(elem){
    // console.log(elem.children);
    let checkbox = elem.querySelector('.form-check-input');
    checkbox.checked = !checkbox.checked;

    // elem.querySelector('.form-check-input').checked=true;
    console.log(elem.querySelector('.form-check-input').value)
}

// This function takes the result list as the input parameter. If the target
// instance is deleted successfully, this function adds a success icon.
// Else, this function will add a fail icon to the result by updating the
// class of the element.
function res_status(res_list){
    const del_book_list = document.querySelectorAll('.del-spin');
    //add spinner
    for(var i = 0; i < del_book_list.length; i++){
        console.log(del_book_list[i]);
        if(res_list[i]>0){
            del_book_list[i].classList.replace('icon-loading', 'icon-Success');
        }else {
            del_book_list[i].classList.replace('icon-loading', 'icon-fail');
        }
    }
}

// This function takes the book list and then sends the data to the target php file.
// The target php file will finish the deletion process and return a result list.
// This function then pass the result to the res_status function to display the
// result.
async function send_booklist(booklist){
    // get current path
    var loc = window.location.href;
    var dir = loc.substring(0, loc.lastIndexOf('/')+1);
    //for php file in the ground directory
    const url = dir+'del_book.php';
    //for php file in this directory
    // const url = "./del_book.php"

    // format the data in JSON
    const format_data = {
        selected_book : booklist
    }
    const formData =JSON.stringify(format_data)
    // send the data to the target php file
    const response = await fetch(url, {
        method: 'post',
        body: formData
    });
    const result_json = await response.text();
    // alert(result_json)
    // parse the sult json
    const result = JSON.parse(result_json);
    // pass the result to res_status
    res_status(result['result'])
};


// This function takes the selected book list as an input parameter.
// While the deletion is still in process, display a loading icon next to
// the selected instance.
function add_spinner(booklist){
    const del_book_list = document.querySelectorAll('.del-spin');
    //add spinner
    for(var i = 0; i < del_book_list.length; i++){
        console.log(del_book_list[i]);
        del_book_list[i].classList.add('iconfont');
        del_book_list[i].classList.add('icon-loading');
    }
}


// get the deletion button
const del_btn = document.getElementById('book_del_btn')

var del_modal_body = document.getElementById('book-del-modal-body');


// book del modal
// Create a modal to display the selected instance and ask user for deletion confirmation.
// If the deletion is confirmed, the selected list will be passed to the target php file
// to finish the deletion process. And the php file will return a result list to display
// the deletion result of each file.
const book_del_modal = (event) =>{
    // create spinner template
    const template = document.getElementById("tem-spinners");
    //  get checkbox value (selected instance)
    var checked = document.querySelectorAll('[name="selected_book"]:checked');
    var book_list = [];

    // get modal body
    const modal_body = document.getElementById('book-del-modal-body');
    const modal_title = document.getElementById('del_modal_title');
    const modal_btn_ok = document.getElementById('del_modal_btn_ok');
    //if the list is not empty, iterate over the list and store the content in a list
    if (checked.length){
        var book_list_string = '<h3> Removing the following books </h3> <div class="row del-book-list">';
        var spinner_div = '<div class="status"></div>'
        for (let selected_book of checked){
            console.log(selected_book['value'])
            book_list_string = book_list_string + "<div class='col-11'>"+selected_book['value']+spinner_div+"</div>"
            book_list_string = book_list_string +"<div class=\"col-1\"><span class=\"del-spin\"></span></div>"
            book_list.push(selected_book['value'])
        }
        modal_title.innerHTML = "Remove Book";
        modal_body.innerHTML=book_list_string+"</div>";

        // open the deletion modal
        var del_modal = new bootstrap.Modal(document.getElementById('del_modal'), {});
        del_modal.show()

        // if click the "ok" button, execute the delete process
        modal_btn_ok.addEventListener('click', ()=>{
            //del ok and cancel button to hide the buttons
            document.getElementById('del_modal_btn_ok').remove();
            document.getElementById('del_modal_btn_cancel').remove();

            // add spin effect
            add_spinner(book_list);

            // send data to target php file and display the result
            send_booklist(book_list);

            // add ok button for close the result window
            let finish_btn_ok = document.createElement('button');
            finish_btn_ok.classList.add("btn");
            finish_btn_ok.classList.add("btn-secondary");
            finish_btn_ok.id = "finish_btn_ok";
            finish_btn_ok.type='submit';
            finish_btn_ok.innerText="Ok";
            let modal_footer = document.getElementsByClassName('modal-footer')[0];
            modal_footer.appendChild(finish_btn_ok);
            // add event listerner
            finish_btn_ok.addEventListener('click',()=>{
                // close modal
                del_modal.hide();
                // refresh page
                window.location.reload();
            })
        })

    }else {
        // if the input data / selected instance is empty, report error
        error_str = "<h3> No book selected </h3>";
        modal_title.innerHTML = "Error";
        modal_body.innerHTML=error_str;
        // open modal
        //open modal
        var del_modal = new bootstrap.Modal(document.getElementById('del_modal'), {});
        del_modal.show()
        // close modal if click ok
        modal_btn_ok.addEventListener('click', () => {del_modal.hide()})
    }
}

// add event listener to the delete button, when the user click the delete button
// the deletion modal will appear. This is the trigger for the whole deleting process.
del_btn.addEventListener('click', book_del_modal)
// del_modal.show();


// define form data, prevent the default behaviour
const selected_book_form = document.getElementById('book_select_form');
selected_book_form.addEventListener('submit',  event =>{
    event.preventDefault();
})