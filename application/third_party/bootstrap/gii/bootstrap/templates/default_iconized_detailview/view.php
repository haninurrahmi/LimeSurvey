<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	\$model->{$nameColumn},
);\n";
?>

$this->menu=array(
	array('label'=>'List <?php echo $this->modelClass; ?>','url'=>array('index'), 'icon'=>'list'),
	array('label'=>'Create <?php echo $this->modelClass; ?>','url'=>array('create'), 'icon'=>'plus-sign'),
	array('label'=>'Update <?php echo $this->modelClass; ?>','url'=>array('update','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>), 'icon'=>'pencil'),
	array('label'=>'Delete <?php echo $this->modelClass; ?>','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>),'confirm'=>'Are you sure you want to delete this item?'), 'icon'=>'trash'),
	array('label'=>'Manage <?php echo $this->modelClass; ?>','url'=>array('admin'), 'icon'=>'list-alt'),
);
?>

<h1>View <?php echo $this->modelClass." #<?php echo \$model->{$this->tableSchema->primaryKey}; ?>"; ?></h1>

<?php echo "<?php"; ?> $this->widget('bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
<?php
foreach($this->tableSchema->columns as $column) {
		echo "\t\tarray(\n";
		echo "\t\t\t"."'name'=>'".$column->name."',\n";
		echo "\t\t\t'value'=>$"."model->".$column->name.",\n";
		echo "\t\t),\n";
	}
?>
	),
)); ?>
