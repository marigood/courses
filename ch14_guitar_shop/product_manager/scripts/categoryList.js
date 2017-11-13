window.onload = setupPage;
var url = "../services/categoryServiceIndex.php";

function setupPage() {
	$("button#addCategory").click(addCategory);
	getCategories();
}

function getCategories(){		
	geturl = url + "?action=getCategories";
	$.getJSON( geturl, createCategoryTable);
}

function createCategoryTable(categories) {
	$("tbody#categoryTable tr").remove();
	$.each(categories, function(i, category) {
		$("tbody#categoryTable").append("<tr><td>" + category.name + "</td>" +
		"<td><button class='deleteCategory' id='" + category.id + "'>Delete</button></td>" + 
        "</tr>");
	});	
	$("button.deleteCategory").click(deleteCategory);
}

function addCategory() {
	categoryName = $("input#categoryName").val();
	addurl = url + "?action=addCategory";
	$.post(addurl, {name: categoryName})
		.done(createCategoryTable)
		.fail(displayError);
}

function deleteCategory() {
	categoryid = this.id;
	deleteurl = url + "?action=deleteCategory";
	$.post(deleteurl, {category_id: categoryid}, createCategoryTable);
}

function displayError()
{
	toastr.error('Something has gone wrong!') 
}