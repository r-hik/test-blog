<?php /* Smarty version Smarty-3.1.12, created on 2013-01-11 02:06:37
         compiled from "templates\index.phtml" */ ?>
<?php /*%%SmartyHeaderCode:490550ef2ef10936b7-47522127%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1f07560281418c212564496accb7681386c7b59f' => 
    array (
      0 => 'templates\\index.phtml',
      1 => 1357869995,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '490550ef2ef10936b7-47522127',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_50ef2ef116d500_17845497',
  'variables' => 
  array (
    'articles' => 0,
    'article' => 0,
    'connecte' => 0,
    'page' => 0,
    'rech' => 0,
    'nb_pages' => 0,
    'i' => 0,
    'nextPage' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50ef2ef116d500_17845497')) {function content_50ef2ef116d500_17845497($_smarty_tpl) {?>﻿<body>

<?php  $_smarty_tpl->tpl_vars['article'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['article']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['articles']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['article']->key => $_smarty_tpl->tpl_vars['article']->value){
$_smarty_tpl->tpl_vars['article']->_loop = true;
?>
				<h3><?php echo $_smarty_tpl->tpl_vars['article']->value['titre'];?>
</h3>
					<p><?php echo $_smarty_tpl->tpl_vars['article']->value['texte'];?>

					
					 </p>
					 ecrit le : <?php echo $_smarty_tpl->tpl_vars['article']->value['date'];?>

					
				<?php if (($_smarty_tpl->tpl_vars['connecte']->value)){?>
					<br><br>
					<a href="article.php?id=<<?php ?>?php echo $data['id']; ?<?php ?>>" class="btn btn-primary">Modifier</a>
					<a href="supprimer-article.php?id=<<?php ?>?php echo $data['id']; ?<?php ?>>" class="btn btn-danger"> Supprimer</a>  
				 
				<?php }?>
				
				<hr>
			<?php } ?>
<div class="pagination" >
	<ul>
		<li class="prev <?php if ($_smarty_tpl->tpl_vars['page']->value<=1){?> disabled<?php }?>" >
			<a id="prev" <?php if ($_smarty_tpl->tpl_vars['page']->value>1){?>href="?p=<?php echo $_smarty_tpl->tpl_vars['page']->value-1;?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['rech']->value){?>&r=<?php echo $_smarty_tpl->tpl_vars['rech']->value;?>
<?php }?>">&larr; Précédent</a>
		</li>
		 <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int)ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? $_smarty_tpl->tpl_vars['nb_pages']->value+1 - (1) : 1-($_smarty_tpl->tpl_vars['nb_pages']->value)+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0){
for ($_smarty_tpl->tpl_vars['i']->value = 1, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++){
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration == 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration == $_smarty_tpl->tpl_vars['i']->total;?><!-- On boucle jusqu a l'avant dernier page-->
						<li<?php if ($_smarty_tpl->tpl_vars['page']->value==$_smarty_tpl->tpl_vars['i']->value){?> class="active"<?php }?>>
							<a  href="?p=<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
<?php if ($_smarty_tpl->tpl_vars['rech']->value){?>&r=<?php echo $_smarty_tpl->tpl_vars['rech']->value;?>
<?php }?>"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
						</li>						
					<?php }} ?>
	

		<li class="next <?php if ($_smarty_tpl->tpl_vars['nextPage']->value>$_smarty_tpl->tpl_vars['nb_pages']->value){?> disabled <?php }?>">
			<a id='next' <?php if ($_smarty_tpl->tpl_vars['page']->value<$_smarty_tpl->tpl_vars['nb_pages']->value){?> href="?p=<?php echo $_smarty_tpl->tpl_vars['page']->value+1;?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['rech']->value){?>&r=<?php echo $_smarty_tpl->tpl_vars['rech']->value;?>
<?php }?>">Suivant &rarr;</a>
		</li>
	</ul>
</div>
<script src='jquery.js'></script>
<script>
	$(function() {
    $('#prev').click(function() {
      $('#body').load('<<?php ?>?php if ($precPage>=1) if($rech) echo "?p=$precPage#body&r=$rech"; else echo "?p=$precPage#body";?<?php ?>>', function() {
      });
    });



    $('#next').click(function() {
      $('#body').load("<<?php ?>?php  if ($nextPage<=$nb_pages)  if($rech) echo '?p=$nextPage#body&r=$rech'; else echo '?p=$nextPage#body';?<?php ?>>", function() {
      });
    });
  });
</script><?php }} ?>