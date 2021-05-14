// WYSWYG Btns
var tt = {
  // Used when user input is needed (images, link).
  input: function (name, title, textdefualt) {
      return document.execCommand(name, false, prompt(title, textdefualt));
  },
}

// Image Upload
function imageUpload(path = '') {

  var query = '?q=' + path;
  var model = `
  <div class="model-bg">
  <div class="close-model" onclick="toggle('img_upload_well');"><i class="far fa-times-circle" title="close"></i></div>
  <iframe id="img_upload_frame" frameborder="0" src="media/browser`+ query +`"></iframe>
  </div>`;

  document.getElementById('img_upload_well').innerHTML = model;
  document.getElementById('img_upload_well').classList.toggle('hide');
}

// Function to remove featured image.
function removeFeaturedImage() {
  document.getElementById('featured_image-preview').innerHTML = '';
  document.getElementById('featured_image-btn').classList.toggle("hide");
  document.getElementById('featured_image-remove').classList.toggle("hide");
  document.getElementById('featured_image-src').value = '';
}

// On block select hide optional items.
function blockOptional() {

  var select = document.getElementById("entity_type").value;
  if (select == 'block') {
    document.getElementById('block_optional').classList.toggle('hide');
    document.getElementById('category-items').classList.toggle('hide');

  } else {
    document.getElementById('block_optional').classList.remove('hide');
    document.getElementById('category-items').classList.remove('hide');
  }

  if (select == 'page') {
    document.getElementById('category-items').classList.toggle('hide');
  }
}

// Tag click and copy
function tagClick(id) {
  var tagValue = document.getElementById(id).innerText;
  var exstingTags = document.getElementById('tags').value;

  if (exstingTags == '') {
    document.getElementById('tags').value = tagValue;
  } else {
    document.getElementById('tags').value = exstingTags + ',' + tagValue
  }
}

// Add autosave.
function tt_autosave() {

  var title = document.getElementById('title');

  if(title.value !== '')
  {
    document.getElementById("entity_form").submit();
  }
}

// Run auto save every 5min
setTimeout(tt_autosave, 300000);

var quill = new Quill('#quill_editor', {
  modules: {
    toolbar: '#toolbar'
  },
  placeholder: 'Enter your text...',
  theme: 'snow'
});

// Copy data from one div to another.
function copyText(from, to) {
  var output = document.getElementsByClassName(from);
  var content = output[0].innerHTML;
  document.getElementById(to).innerHTML = content;
}

// Prior to submiting the content create form, run this script to copy data to hidden textbox.
document.getElementById("entity_form").onsubmit = function() {
  copyText('ql-editor', 'page_data');
};