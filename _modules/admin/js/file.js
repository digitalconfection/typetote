// this file on click should get the data id value, then somehow it needs to pass into the parent which is the main page
function placeFile(file) {

  const query = getUrlParameter('q');

  // If we are calling the browser from outside of the WYSIWYG
  if (query) {
      
    // alert(query);
    window.top.document.getElementById(query + '-preview').innerHTML = `<img src=` + file + `>`;
    window.top.document.getElementById(query + '-src').value = file;
    window.top.document.getElementById("img_upload_well").classList.toggle("hide");
    window.top.document.getElementById("featured_image-btn").classList.toggle("hide");
    window.top.document.getElementById("featured_image-remove").classList.toggle("hide");
    

  } else {

    var img = `<br><span class="emb-image-well"><img src="`+ file + `" class="emb-image"></span>`;
    window.top.document.execCommand("insertHTML",false, img);
    window.top.document.execCommand("insertLineBreak");
    window.top.document.getElementById("img_upload_well").classList.toggle("hide");
    copyText('wysiwyg_editor', 'page_data');
  }

}

// Get parm
function getUrlParameter(name) {
  name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
  var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
  var results = regex.exec(location.search);
  return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
};

// Toggle div.
function toggle(elm) {
  document.getElementById(elm).classList.toggle('hide');
}

// Toggle, close hide upload form.
function closeParent(elm) {
  parent.top.document.getElementById(elm).classList.toggle('hide');
}