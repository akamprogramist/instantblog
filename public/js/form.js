var ct = 1;
var targetToAppend = document.getElementById("dynamic_field");

function addNew(value) {
    ct++;
    var div1 = document.createElement("div");
    div1.className = "mb-3 row";
    div1.id = ct;
    var delLink =
        '<div class="col-sm-1 col-md-1 d-flex align-items-center"><span class="span-click me-3 text-danger" onclick="delIt(' +
        ct +
        ')"><i class="icon-x-circle fw-bold"></i></span><span class="span-move"><i class="icon-arrows-move fw-bold"></i></span></div>';
    div1.innerHTML = document.getElementById(value).innerHTML + delLink;
    targetToAppend.appendChild(div1);
    window.scrollTo(0, 10000);
}
// Delete Element Function //
function delIt(eleId) {
    var ele = document.getElementById(eleId);
    var parentEle = document.getElementById("dynamic_field");
    parentEle.removeChild(ele);
}
// Delete Content Function //
function delCont(cont) {
    let ele = cont.closest(".mb-3");
    let parentEle = document.getElementById("dynamic_field");
    parentEle.removeChild(ele);
}

function addText() {
    ct++;
    var div1 = document.createElement("div");
    div1.className = "mb-3 row";
    div1.id = ct;
    var delLink =
        '<label class="offset-md-1 col-md-2 col-form-label">' +
        formtext +
        '</label><div class="col-sm-10 col-md-7 myeditor"><div id="editor' +
        ct +
        '"></div><input class="txtcont" type="hidden" name="content[]"><input type="hidden" name="type[]" value="txteditor"><input type="hidden" name="extra[]"></div><div class="col-sm-1 col-md-1 d-flex align-items-center mt-3"><span class="span-click me-3 text-danger" onclick="delIt(' +
        ct +
        ')"><i class="icon-x-circle fw-bold"></i></span><span class="span-move"><i class="icon-arrows-move fw-bold"></i></span></div>';
    div1.innerHTML = delLink;
    document.getElementById("dynamic_field").appendChild(div1);
    window.scrollTo(0, 10000);
    quillINT(ct);
}

// Post submit Function //
function ClickForm() {
    event.preventDefault();
    let elements = document.querySelectorAll(".ql-editor");
    if (elements.length > 0) {
        elements.forEach(function (element) {
            element.closest(".myeditor").querySelector(".txtcont").value =
                element.innerHTML;
        });
    }
    let postForm = document.getElementById("post_form");
    let url = postForm.action;
    let formData = new FormData(postForm);
    let token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    let successMsg = document.getElementById("show-msg");
    let errorMsg = document.getElementById("show-err-msg");
    let ul = document.getElementById("list");
    let embedBtn = document.querySelector("#submit");
    let orgBtn = embedBtn.innerHTML;
    embedBtn.disabled = true;
    embedBtn.innerHTML =
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ' +
        processing;

    fetch(url, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": token,
        },
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                postForm.reset();
                postForm.outerHTML = "";
                successMsg.classList.remove("d-none");
                successMsg.innerHTML += data.success;
            } else {
                embedBtn.innerHTML = orgBtn;
                embedBtn.disabled = false;
                ul.innerHTML = "";
                errorMsg.classList.remove("d-none");
                Object.entries(data.error).forEach(([key, value]) => {
                    ul.innerHTML += "<li>" + value + "</li>";
                });
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            embedBtn.innerHTML = orgBtn;
            embedBtn.disabled = false;
        });
}

// Image Upload Function //
function ImageUpload(input) {
    const file = input.files[0];
    let ownDiv = input.closest(".mb-3");
    let photoUpload = ownDiv.querySelector(".photo_upload");
    let spanClick = ownDiv.querySelector(".span-click");
    let fileInputs = ownDiv.querySelector(".fileinputs");
    let fileInfo = ownDiv.querySelector(".fileinfo");
    fileInfo.innerHTML = "<p>" + fileUploading + "</p>";

    let formData = new FormData();
    formData.append("post_image", file);
    let token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    fetch(imgURL, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": token,
        },
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                if (spanClick) {
                    spanClick.classList.add("d-none");
                }
                photoUpload.value = data.success;
                if (photoUpload.name == "post_media") {
                    fileInfo.innerHTML =
                        "<div class='flex-shrink-0'><img class='imgthumb img-fluid' src='" +
                        avatarURL +
                        "/" +
                        data.success +
                        "'></div><div class='flex-grow-1 ms-3'><input class='form-control' type='text' name='media_alt' placeholder='" +
                        imagealt +
                        "' aria-label='Image Alt'></div>";
                } else {
                    fileInfo.innerHTML =
                        "<div class='flex-shrink-0'><img class='imgthumb img-fluid' src='" +
                        avatarURL +
                        "/" +
                        data.success +
                        "'></div><div class='flex-grow-1 ms-3'><div class='input-group'><input class='form-control' type='text' name='extra[]' placeholder='" +
                        imagealt +
                        "' aria-label='Image Alt'><input class='form-control' type='text' name='link[]' placeholder='" +
                        link +
                        "' aria-label='Link'><select class='form-select short-select'  name='blank[]' aria-label='blankselect'><option value='0' selected>" +
                        self +
                        "</option><option value='1'>" +
                        blank +
                        "</option></select></div>";
                }
                fileInputs.innerHTML =
                    "<button type='button' onclick='ImageDelete(this)' class='btn btn-warning removeimg'>" +
                    removetxt +
                    "</button>";
            } else {
                fileInfo.innerHTML =
                    '<p class="text-danger">' + data.error[0] + "</p>";
            }
        })
        .catch((error) => {
            console.error("error:", error);
        });
}

// Image Delete Function //
function ImageDelete(input) {
    let ownDiv = input.closest(".mb-3");
    let photoUpload = ownDiv.querySelector(".photo_upload");
    let spanClick = ownDiv.querySelector(".span-click");
    let fileInputs = ownDiv.querySelector(".fileinputs");
    let fileInfo = ownDiv.querySelector(".fileinfo");

    let formData = new FormData();
    formData.append("id", photoUpload.value);
    let token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    fetch(delURL, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": token,
        },
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                if (spanClick) {
                    spanClick.classList.remove("d-none");
                }
                photoUpload.value = "";
                fileInfo.innerHTML = "<p>" + data.success + "</p>";
                fileInputs.innerHTML =
                    "<label class='btn btn-info btnfile'>" +
                    browse +
                    "<input onchange='ImageUpload(this)' class='fileupload d-none' type='file' name='post_image'></label>";
            } else {
                fileInfo.innerHTML =
                    '<p class="text-danger">' + data.error[0] + "</p>";
            }
        })
        .catch((error) => {
            console.error("error:", error);
        });
}

function ImageRemove(input) {
    let ownDiv = input.closest(".mb-3");
    let photoUpload = ownDiv.querySelector(".photo_upload");
    let fileInfo = ownDiv.querySelector(".fileinfo");
    let fileInputs = ownDiv.querySelector(".fileinputs");
    photoUpload.value = "";
    fileInfo.innerHTML = "<p>" + imgremoved + "</p>";
    fileInputs.innerHTML =
        "<label class='btn btn-info w-100 btnfile'>" +
        browse +
        "<input onchange='ImageUpload(this)' class='fileupload d-none' type='file' name='post_image'></label>";
}

// Post embed Function //
function ClickEmbed(embed) {
    let ownDiv = embed.closest(".mb-3");
    let embedForm = ownDiv.querySelector("input[name='embed_url']");
    let embedBtn = ownDiv.querySelector(".btn");
    let embedCont = ownDiv.querySelector("input[name='content[]']");
    let orgBtn = embedBtn.innerHTML;
    embedBtn.disabled = true;
    embedBtn.innerHTML =
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ' +
        processing;
    let embedType = ownDiv.querySelector("input[name='type[]']").value;
    let token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    let errorData = ownDiv.querySelector(".errordata");

    fetch(embedURL, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Accept: "application/json, text-plain, */*",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": token,
        },
        body: JSON.stringify({
            embed: embedForm.value,
            type: embedType,
            extra: null,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                embedBtn.disabled = false;
                embedBtn.setAttribute("onClick", "RemoveEmbed(this)");
                embedBtn.classList.remove("btn-success");
                embedBtn.classList.add("btn-warning");
                embedBtn.innerHTML = removetxt;
                embedCont.value = data.success;
                embedForm.readOnly = true;
                if (errorData) {
                    errorData.remove();
                }
            } else {
                embedBtn.disabled = false;
                embedBtn.innerHTML = orgBtn;
                embedForm.value = "";
                if (errorData) {
                    errorData.remove();
                }
                ownDiv.innerHTML +=
                    "<small class='offset-md-3 col-md-8 col-form-label text-danger errordata'>" +
                    data.error +
                    "</small>";
            }
        })
        .catch((error) => {
            console.error("error:", error);
        });
}

// Remove embed Function //
function RemoveEmbed(embed) {
    let ownDiv = embed.closest(".mb-3");
    let embedForm = ownDiv.querySelector("input[name='embed_url']");
    let embedCont = ownDiv.querySelector("input[name='content[]']");
    let embedBtn = ownDiv.querySelector(".btn");

    embedForm.value = "";
    embedCont.value = "";
    embedForm.readOnly = false;
    embedBtn.setAttribute("onClick", "ClickEmbed(this)");
    embedBtn.classList.remove("btn-warning");
    embedBtn.classList.add("btn-success");
    embedBtn.innerHTML = embedtxt;
}

function quillINT(ct) {
    var quill = new Quill("#editor" + ct, {
        theme: "snow",
        modules: {
            toolbar: toolbarOptions,
        },
    });
}
