<?php
class Visual_editor
{
	private $loaded_editor;
	public function __construct()
	{
		$this->instance		=	get_instance();
		$this->instance->file->js_push('ckeditor/ckeditor');
		$this->instance->file->js_push('ckeditor/adapters/jquery');
	}
	public function loadEditor($id=1)// Obsolète
	{
	}
	public function getEditor($values,$type	=	'editor')
	{
		$toolBarConfig	=	'';
		$customConfig	=	'';
		if($type	==	'editor')
		{
			$toolBarConfig	=	"toolbar: [
				['Source'],
				{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'Outdent', 'Indent','Blockquote', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
				['Styles','Format','Colors'],
				['Bold','Italic'],
				['Undo','Redo'],
				{ name: 'links', items: [ 'Link', 'Unlink'] },
				['NumberedList','BulletedList','Maximize'],
				
				['Cut','Copy','Paste','PasteText','PasteFromWord'],
				['Image','links']
			],height:400";
		}
		else if($type	==	'coder')
		{
			$customConfig	=	"
				CKEDITOR.config.extraPlugins 			= '';
				CKEDITOR.config.startupMode 			= 'source';
				CKEDITOR.config.extraAllowedContent 	= 'b,big,code,del,dfn,em,font,i,ins,kbd';
				CKEDITOR.config.codemirror				=	{
					lineWrapping						: 	true,
					showAutoCompleteButton				: 	true,
					allowedContent						: true
				};
			";
		}
		else if($type	==	'advanced')
		{
			$toolBarConfig	=	"toolbarGroups: [
				{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
				{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
				{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ] },
				{ name: 'forms' },
				'/',
				{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
				{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
				{ name: 'links' },
				{ name: 'insert' },
				'/',
				{ name: 'styles' },
				{ name: 'colors' },
				{ name: 'tools' },
				{ name: 'others' },
				{ name: 'about' }
			]";
		}
		$default	=	array(
			'id'			=>'ckeditor',
			'width'			=>900,
			'height'		=>800,
			'cssclass'		=>'tinyeditor',
			'controlclass'	=>'tinyeditor-control',
			'rowclass'		=>'tinyeditor-header',
			'dividerclass'	=>'tinyeditor-divider',
			'controls'		=>array('bold', 'italic', 'underline', 'strikethrough', '|', 'subscript', 'superscript', '|',
				'orderedlist', 'unorderedlist', '|', 'outdent', 'indent', '|', 'leftalign',
				'centeralign', 'rightalign', 'blockjustify', '|', 'unformat', '|', 'undo', 'redo', 'n',
				'font', 'size', 'style', '|', 'image', 'hr', 'link', 'unlink', '|', 'print'),
			'footer'		=>'true',
			'fonts'			=>array('Verdana','Arial','Georgia','Trebuchet MS'),
			'xhtml'			=>'true',
			'cssfile'		=>'custom.css',
			'bodyid'		=>'editor',
			'footerclass'	=>'tinyeditor-footer',
			'toggle'		=>array('text'=>'source','activetext'=>'wysiwyg','cssclass'=>'toggle'),
			'resize'		=>array('cssclass'=>'resize'),
			'defaultValue'	=>''		
		);
		$default			=	array_merge($default,$values);
		if(array_key_exists('defaultValue',$default))
		{
			$defValue	=	$default['defaultValue'];
		}
		else
		{
			$defValue	=	'';
		}
		if(!array_key_exists('id',$values)): $values['id']		=	'';endif;
		if(!array_key_exists('name',$values)): $values['name']	=	'';endif;
		return "<textarea class=\"cked\" name=\"".$values['name']."\" id=\"".$values['id']."\" style='height:".$default['height']."px;width:".$default['width']."px;'>".$defValue."</textarea>
		<script>
		".$customConfig."
		var ".$values['id']."	=	
		CKEDITOR.replace('".$values['id']."',{
			".$toolBarConfig.",
			heigth	:	'500px'
		});
		</script>
			";
	}
}