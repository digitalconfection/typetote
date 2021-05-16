<div class="page-well">
  <div class="edit-bar" id="edit-bar">
    <div class="well">
      <div id="toolbar">
        <select class="ql-header">
          <option value="2"></option>
          <option value="3"></option>
          <option selected></option>
        </select>
        <div class="toolbar-btns">
          <button class="ql-bold"></button>
          <button class="ql-italic"></button>
          <button class="ql-underline"></button>
          <button class="ql-blockquote"></button>
          <button class="ql-code-block"></button>
          <button class="ql-link"></button>
          <button class="ql-list" value="ordered"></button>
          <button class="ql-list" value="bullet"></button>
          <button class="ql-img" title="Insert Image" onclick="imageUpload();"><i class="fas fa-image"></i></button>
          <button class="ql-clean"></button>
        </div>
      </div>
    </div>
  </div>
  <div class="page-content" id="wysiwyg_well">
    <div id="quill_editor" class="editor" contenteditable="true" placeholder="Enter Text..."><?php if (isset($page_data['body'])) { echo $page_data['body']; } ?></div>
  </div>
  <textarea class="full-html-block hide" id="page_data" name="entity[body]"><?php if (isset($page_data['body'])) { echo $page_data['body']; } ?></textarea>
</div>

<div id="img_upload_well" class="media-model hide"></div>