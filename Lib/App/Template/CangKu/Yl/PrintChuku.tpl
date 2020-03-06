<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="Resource/Css/Edit100.css" rel="stylesheet" type="text/css" />
<title>无标题文档</title>
</head>
{literal}
<style type="text/css">
.table{text-align:center; font:13px Arial; width:98%; border-bottom:solid 2px black; border-right: solid 2px black }
.table td {border-top:solid 1px black; border-left:solid 1px black;}
.title{ font:bold;}
ul{ list-style:none; margin:0; float:left;}
li{ display:inline;}
li span{padding-left:20px;}
</style>
{/literal}
<body>
<div style="margin:0 1%;" align="center">
      {webcontrol type='GetAppInf' varName='compName'}<br/>
      <span class="title">领料登记单</span>
     <div style="width:100%">
      <ul>
      <li>出库日期：</li>
      <li>{$arr_field_value.0.chukuDate|default:'&nbsp;'}</li>
      <li><span>出库单号：</span></li>
      <li>{$arr_field_value.0.chukuNum|default:'&amp;nbsp;'}</li>
      <li style=" width:50%;"></li>
      <li><span>领料部门：</span></li>
      <li>{$arr_field_value.0.Department.depName|default:'&amp;nbsp;'}</li>
      </ul>
     </div>

      
  <table border="0" cellspacing="0" cellpadding="0" class="table" >
    <tr class="title">
      <td>品名规格</td>
      <td>数量（KG）</td>
      <td>单价</td>
      <td>金额</td>
    </tr>
    {foreach from=$arr_field_value item=item}
    <tr>
      <td>{$item.guige|default:'&nbsp;'}</td>
      <td>{$item.cnt|default:'&nbsp;'}</td>
      <td>{$item.danjia|default:'&nbsp;'}</td>
      <td>{$item.money|default:'&nbsp;'}</td>
    </tr>
    {/foreach}

  </table>
   <input name="button1" type="button" value="打印" onclick="window.print()" /></td>
</div>
</body>
</html>
