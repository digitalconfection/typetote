// Ensure that the first line of the wyswyg is at most a paragraph tag.
document.execCommand('defaultParagraphSeparator', false, 'p');
function firstParagraph() {
  let wsywg_editor = document.getElementById('wysiwyg_editor');
  if (wsywg_editor.innerHTML == '') {
      document.execCommand('formatBlock', false, 'p')
    }
}

// WYSWYG Btns
var tt = {
  // Used when text is altered
  text: function (name) {
      return document.execCommand(name, false, '');
  },

  // Used when user input is needed (images, link).
  input: function (name, title, textdefualt) {
      return document.execCommand(name, false, prompt(title, textdefualt));
  },

  format: function (tag) {
      document.execCommand('formatBlock', false, tag);
  },
}

// Paste data as plaintext.
// document.addEventListener("paste", function(e) {
//   // cancel paste
//   e.preventDefault();

//   // get text representation of clipboard
//   var text = (e.originalEvent || e).clipboardData.getData('text/plain');

//   // insert text manually
//   document.execCommand("insertHTML", false, text);
// });

// Copy data from one div to another.
function copyText(from, to) {
  var output = document.getElementById(from).innerHTML;
  document.getElementById(to).innerHTML = output;
}

// switchBlockEidtor
function switchBlockEidtor() {
  
  var prompt = confirm("Switching to modes will lose any new changes you make.");
  if (prompt == true) {
    document.getElementById('wysiwyg_well').classList.toggle('hide');
    document.getElementById('wsywyg-btns').classList.toggle('hide');
    document.getElementById('page_data').classList.toggle('hide');
  }

}

// Image Upload
function imageUpload() {

  document.getElementById('img_upload_well').classList.toggle('hide');
 
}

// Add the sticky class to wyswyg editor.
function stickyHeader() {
    var header = document.getElementById("edit-bar");
    var sticky = header.offsetTop;
  
  if (window.pageYOffset > sticky) 
  {
    header.classList.add("sticky");
  } 
  else 
  {
    header.classList.remove("sticky");
  }
}
window.onscroll = function() {stickyHeader()};

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
function tagClick(id)
{
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
