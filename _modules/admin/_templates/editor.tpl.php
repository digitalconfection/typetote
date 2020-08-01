<div class="page-well">
  <div class="edit-bar" id="edit-bar">
    <div class="well">
      <div id="wsywyg-btns">
        <a class="wy_btn bold-icon" title="Heading (h2)" onclick="tt.format('h2');" href="javascript:void(0);">H2</a>
        <a class="wy_btn bold-icon" title="Heading (h3)" onclick="tt.format('h3');" href="javascript:void(0);">H3</a>
        <a class="wy_btn" title="Bold" onclick="tt.text('bold');" href="javascript:void(0);"><i class="fa fa-bold" aria-hidden="true"></i></a>
        <a class="wy_btn" title="Underline" onclick="tt.text('underline');" href="javascript:void(0);"><i class="fa fa-underline" aria-hidden="true"></i></a>
        <a class="wy_btn" title="Italic" onclick="tt.text('italic');" href="javascript:void(0);"><i class="fa fa-italic" aria-hidden="true"></i></a>
        <a class="wy_btn" title="New Line" onclick="tt.text('insertLineBreak');" href="javascript:void(0);">⏎</a>
        <span class="wy_space" >| </span>
        <a class="wy_btn" title="Justify Left" onclick="tt.text('justifyLeft');" href="javascript:void(0);"><i class="fas fa-align-left"></i></a>
        <a class="wy_btn" title="Justify Center" onclick="tt.text('justifyCenter');" href="javascript:void(0);"><i class="fas fa-align-center"></i></a>
        <a class="wy_btn" title="Justify Center" onclick="tt.text('justifyRight');" href="javascript:void(0);"><i class="fas fa-align-right"></i></a>
        <span class="wy_space" >| </span>
        <a class="wy_btn" title="Ordered List" onclick="tt.text('insertOrderedList');" href="javascript:void(0);"><i class="fa fa-list-ol" title="Unordered List" aria-hidden="true"></i></a>
        <a class="wy_btn" onclick="tt.text('insertUnorderedList');" href="javascript:void(0);"><i class="fa fa-list" aria-hidden="true"></i></a>
        <span id="img-span-wy">
        <span class="wy_space" >| </span>
        <a class="wy_btn" title="Insert Image" onclick="imageUpload();" href="javascript:void(0);"><i class="fas fa-image"></i></a>
        <span class="wy_space" >| </span>
        <a class="wy_btn" title="Hyperlink" onclick="tt.input('createLink', 'Enter link', 'https://');" href="javascript:void(0);"><i class="fas fa-link" aria-hidden="true"></i></a>
        <a class="wy_btn"  title="Remove Hyperlink" onclick="tt.text('unlink');" href="javascript:void(0);"><i class="fas fa-unlink"></i></a>
        <span class="wy_space" >| </span>
        <a class="wy_btn" title="Format Code" onclick="tt.format('pre');" href="javascript:void(0);"><i class="fa fa-code" aria-hidden="true"></i></a>
        <a class="wy_btn" title="Remove Format" onclick="tt.text('removeFormat');" href="javascript:void(0);"><i class="fa fa-eraser" aria-hidden="true"></i></a> 
      </div>
      <a class="wy_btn" title="Block / HTML" onclick="switchBlockEidtor();" href="javascript:void(0);"><i class="fab fa-codepen"></i></a> 
    </div>
  </div>
  <div class="page-content" id="wysiwyg_well">
    <div id="wysiwyg_editor" class="editor" onclick="firstParagraph(); copyText('wysiwyg_editor', 'page_data');" onkeydown="copyText('wysiwyg_editor', 'page_data')" onkeyup="copyText('wysiwyg_editor', 'page_data')" contenteditable="true" placeholder="Enter Text..."><?php if (isset($page_data['body'])) { echo $page_data['body']; } ?></div>
  </div>
  <textarea class="full-html-block hide" id="page_data" name="entity[body]"><?php if (isset($page_data['body'])) { echo $page_data['body']; } ?></textarea>
</div>

<div id="img_upload_well" class="media-model hide"></div>

