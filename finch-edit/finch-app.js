jQuery(document).ready(function( $ ) {
		fieldInputValue = {};

		function ttLiveEdit(thattt){

			if(fieldediting.hasClass('field-nomimic')){

			}else{

				if (fieldediting.length) {
						var formValue = thattt.html();
						fieldediting.html(formValue); 	
				} else {
				
				}
			}
		}

		function ttSimpleEdit(thattt){
			
			if(fieldediting.hasClass('field-nomimic')){

			}else{

				if (fieldediting.length) {
						var formValue = thattt.val();
						fieldediting.html(formValue); 
				} else {

				}
			}
		}

				$("#editform").find('input[value="Update"]').after(function(){
					return "<button class='cancel-button' type='button'>Cancel</button>";
				});			

				

					$("body").on("click", ".edit-link", function(){
					event.preventDefault();
					var that = $(this);
					var fieldForm = $("#editform");
					var fieldParent = $(that).prev(".editable-field");

					var fieldId = "." + fieldParent.attr("id");
					var fieldAcfId = that.attr("href");
					var formHtml = fieldForm.html();
					var formButton = fieldForm.find('input[value="Update"]');

					fieldForm.css({
						"position" : "fixed",
						"top" : "40px",
						"left" : "20px"
					});
					fieldediting = $(that).prev(".editable-field");
					console.log(fieldediting.html());
					$(".field").hide();	
					$(".edit-link").hide();
					fieldForm.show();
					fieldForm.find('input[value="Update"]').parent().show();
					$(fieldAcfId).show();
					$(".active-field").removeClass("active-field");
					$(fieldAcfId).addClass("active-field");
					$(".active-field").show();
					fieldParent.css("box-shadow", "none");

					if($(".active-field input").length){

						fieldForm.css({
  			 				'overflow' : 'hidden',
  		 					'width' : '636px',
  		 					"height" : "230px"
						});

						fieldInputValue.original = $(".active-field input").val();

					}

					if($(".active-field textarea").length){

						if($(".active-field iframe").length){

							if(fieldediting.html()){

								fieldForm.css({
  			 					'overflow' : 'hidden',
   								'width' : '636px',
   								"height" : "420px"
								});

								fieldInputValue.original = $(".active-field textarea").val();

							}else{

								fieldForm.css({
  			 					'overflow-y' : 'scroll',

   								'width' : '636px',
   								"height" : "600px"
								});

							}

						}else{

							fieldForm.css({
  			 					'overflow' : 'hidden',

   								'width' : '636px',
   								"height" : "330px"
							});

							fieldInputValue.original = $(".active-field textarea").val();
						}
					}	
				});
			

// setTimeout(your_func, 3000);
// function your_func(){
// $("iframe").contents().find("body").on("keyup", function(){

// 						var that = $(this);
// 						console.log(that);
// 						ttLiveEdit(that);
						
// 					});

// }
					
var iframeIntervalID;
function checkForLoadedIFrames() {

       var bodies = $('iframe').contents().find('body');
       // console.log($('iframe').length);
       // console.log(bodies.length);
       if ($('iframe').length === bodies.length) {
               clearInterval(iframeIntervalID);
               $('iframe').contents().find('body').on("keyup", function(){
               	console.log("working");
               	var that = $(this);
               	tinyMCE.triggerSave(); 
				ttLiveEdit(that);
               });
               $("#editform").on("click", ".active-field", function(){
                $('.active-field iframe').contents().find('body').trigger('keyup');
               });
       }
}

iframeIntervalID = setInterval(checkForLoadedIFrames, 3000);


					$("#editform").on("keyup", ".active-field input", function(){
						var that = $(this);
						ttSimpleEdit(that);
						
					});

					$("#editform").on("paste", ".active-field input", function(){
			
						var that = $(this);
						ttSimpleEdit(that);
				
					});

					$("#editform").on("cut", ".active-field input", function(){
			
						var that = $(this);
						ttSimpleEdit(that);
				
					});

					$("#editform").on("change", ".active-field input", function(){
			
						var that = $(this);
						ttSimpleEdit(that);
				
					});

					$("#editform").on("change", ".active-field textarea", function(){

						var that = $(this);
						ttSimpleEdit(that);
					});


					$("#editform").on("paste", ".active-field textarea", function(){
			
						var that = $(this);
						ttSimpleEdit(that);
				
					});

					$("#editform").on("keyup", ".active-field textarea", function(){

						var that = $(this);
						ttSimpleEdit(that);
					});


					$("#editform").on("cut", ".active-field textarea", function(){
			
						var that = $(this);
						ttSimpleEdit(that);
				
					});


					$("body").on("mouseenter", ".field-container", function(){
						var that = $(this);
						if($("#editform").css('display') == 'none'){
						$(that).find(".editable-field").css("box-shadow", "0 4px 6px -6px #000");
						$(that).find(".edit-link").fadeIn(100);
						}
					});
					$("body").on("mouseleave", ".field-container", function(){
						var that = $(this);
						if($("#editform").css('display') == 'none'){
							$(that).find(".editable-field").css("box-shadow", "none");
						$(that).find(".edit-link").fadeOut(100);
					}
					});


					$("body").on("click", ".cancel-button", function(){
						
						if($(".active-field input").length){
							if($(".active-field iframe").length || $(".active-field textarea").length){

							} else{
							$(".active-field input").val(fieldInputValue.original);
						}
						}
						if($(".active-field textarea").length){
							if($(".active-field iframe").length){
								if(fieldediting.html()){
							$(".active-field textarea").val(fieldInputValue.original);
							$(".active-field iframe").contents().find('body').html(fieldInputValue.original);
							}
							} else {
							$(".active-field textarea").val(fieldInputValue.original);

							}
						}

						$("#editform").hide();
						$(".field").hide();
						$(".active-field").removeClass("active-field");
						$(".editable-field").css("opacity","1");
						if(fieldediting.hasClass('field-nomimic')){
						}else{
							formContent = fieldInputValue.original;
						// formContent = fieldInputValue.original.replace(/\n/g, '<br />');
						fieldediting.html(formContent); 
					
					}
					});

if($("#editform").length > 0){
$("#editform").draggable({ handle: ".formhandle" });
$( ".formhandle" ).disableSelection();
$( "#editform" ).resizable({
minHeight: 150,
minWidth: 150
});
}

$(".editable-field").each(function(){
	var that = $(this);
	var thatId = that.attr("id");
	var thatAllClasses = that.attr("class");
	var thatClass = thatAllClasses.replace("editable-field","");

	that.wrap ("<div class='field-container' />");
	that.after ("<a class='edit-link "+thatClass+"' href='#acf-"+thatId+"'>Edit</a>");
	// function tt_edit_button($fieldname, $extraclass) {
	// 	if (is_super_admin()){

	// 		$titleid1 = get_field_object($fieldname);
	// 		$titleid = $titleid1["name"];

	// 		if (is_null($extraclass)){
	// 			echo "<a class='edit-link' href='#acf-";
	// 			echo $titleid;
	// 			echo "'>Edit</a>";
	// 		}else{
	// 			echo "<a class='edit-link ";
	// 			echo $extraclass;
	// 			echo "' href='#acf-";
	// 			echo $titleid;
	// 			echo "'>Edit</a>";
	// 		}
	// 	} 
	// }

});

});