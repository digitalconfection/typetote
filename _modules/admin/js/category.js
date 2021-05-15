var obNum = {
  count: function(name) {
      var id = document.getElementsByClassName(name).length;
      return id++;
  }
}

// Add new category row to form.
function addCategoryRow() {

  var div = document.createElement("div");
  div.className= 'cat_obj';
  div.id = 'ob_'+ obNum.count('cat_obj') +'';
  div.innerHTML= `
      <div>
        <input type="text" name="cat[`+ obNum.count('cat_obj')  +`][name]" placeholder="Category Name">
        <input type="text" name="cat[`+obNum.count('cat_obj')  +`][path]" placeholder="Category Path (Must not have any spaces i.e &quot;dinner-menu&quot;)">
      </div>
      <textarea name="cat[`+obNum.count('cat_obj')  +`][description]" placeholder="Category Description"></textarea>
      <span class="x" onclick="removeCategory('ob_`+ obNum.count('cat_obj') +`');"><i class="fas fa-ban"></i></span>
      `;
  document.getElementById('category_well').appendChild(div);
}

// Remove cat Item
function removeCategory(id) {
  document.getElementById(id).outerHTML = "";
}