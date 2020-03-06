<?xml version="1.0"?>
<?mso-application progid="Excel.Sheet"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
  <Created>1996-12-17T01:32:42Z</Created>
  <LastSaved>2016-08-10T08:32:24Z</LastSaved>
  <Version>11.9999</Version>
 </DocumentProperties>
 <OfficeDocumentSettings xmlns="urn:schemas-microsoft-com:office:office">
  <RemovePersonalInformation/>
 </OfficeDocumentSettings>
 <ExcelWorkbook xmlns="urn:schemas-microsoft-com:office:excel">
  <WindowHeight>4530</WindowHeight>
  <WindowWidth>8505</WindowWidth>
  <WindowTopX>480</WindowTopX>
  <WindowTopY>120</WindowTopY>
  <AcceptLabelsInFormulas/>
  <ProtectStructure>False</ProtectStructure>
  <ProtectWindows>False</ProtectWindows>
 </ExcelWorkbook>
 <Styles>
  <Style ss:ID="Default" ss:Name="Normal">
   <Alignment ss:Vertical="Bottom"/>
   <Borders/>
   <Font ss:FontName="宋体" x:CharSet="134" ss:Size="12"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID="s21">
   <Font ss:FontName="宋体" x:CharSet="134"/>
  </Style>
  <Style ss:ID="s22">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="宋体" x:CharSet="134" ss:Bold="1"/>
  </Style>
  <Style ss:ID="s23">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
  </Style>
  <Style ss:ID="s26">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="宋体" x:CharSet="134"/>
  </Style>
  <Style ss:ID="s27">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Font ss:FontName="宋体" x:CharSet="134" ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s28">
   <Alignment ss:Horizontal="Left" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="宋体" x:CharSet="134" ss:Size="12" ss:Bold="1"/>
  </Style>
  <Style ss:ID="s29">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Font ss:FontName="宋体" x:CharSet="134" ss:Size="16" ss:Bold="1"/>
  </Style>
 </Styles>
 <Worksheet ss:Name="Sheet1">
  <Table  ss:DefaultColumnWidth="54" ss:DefaultRowHeight="14.25">
   <Column ss:AutoFitWidth="0" ss:Width="87.75"/>
   <Column ss:Index="4" ss:Width="63"/>
   <Row ss:Height="20.25">
    <Cell ss:MergeAcross="7" ss:StyleID="s29"><Data ss:Type="String">{$title}</Data></Cell>
   </Row>
   {foreach from=$orders item='aOrder'}
   {if $aOrder.isShow==true}
   {assign var="tCnt" value=0}
   {assign var="tTongzi" value=0} 
   <Row>
    <Cell ss:MergeAcross="7" ss:StyleID="s28"><Data ss:Type="String"> {$aOrder.dateOrder},{$aOrder.Client.compName},订单号:{$aOrder.orderCode},产品类别:{$aOrder.SaleKind.kindName},交货日期:{$aOrder.dateJiaohuo}</Data></Cell>
   </Row>
   <Row ss:StyleID="s23">
    <Cell ss:StyleID="s22"><Data ss:Type="String">纱支规格</Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="String">颜色</Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="String">色号</Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="String">缸号</Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="String">经</Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="String">伟</Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="String">合计</Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="String">筒子数</Data></Cell>
<!--     <Cell ss:StyleID="s22"><Data ss:Type="String">松筒</Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="String">高台染色</Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="String">烘纱</Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="String">回倒</Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="String">发货</Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="String">打样人</Data></Cell> -->
   </Row>
  {foreach from=$aOrder.Ware item='aOrdPro' key=key}
  {foreach from=$aOrdPro item=item key=key1}
    {if $item.isShow}
    {if $item.Gang}
    {foreach from=$item.Gang item='aGang' key=key2}
    {if $aGang.isShow}
    {math equation="x + y" x=$aGang.cntPlanTouliao y=$tCnt assign='tCnt'}
    {math equation="x + y" x=$aGang.planTongzi y=$tTongzi assign='tTongzi'}
   <Row>
    <Cell ss:StyleID="s26"><Data ss:Type="String">{*{if $key1 == 0 && $key2 == 0}{$key}{else}&nbsp;{/if}*}{$key}</Data></Cell>
    <Cell ss:StyleID="s26"><Data ss:Type="String">{$item.color}</Data></Cell>
    <Cell ss:StyleID="s26"><Data ss:Type="String">{$item.colorNum|default:'&nbsp;'}</Data></Cell>
    <Cell ss:StyleID="s26"><Data ss:Type="String">{$aGang.vatNum}</Data></Cell>
    <Cell ss:StyleID="s26"><Data ss:Type="Number">{$aGang.cntJ|default:'&nbsp;'}</Data></Cell>
    <Cell ss:StyleID="s26"><Data ss:Type="Number">{$aGang.cntW}</Data></Cell>
    <Cell ss:StyleID="s26"><Data ss:Type="Number">{$aGang.cntPlanTouliao}</Data></Cell>
    <Cell ss:StyleID="s26"><Data ss:Type="Number">{$aGang.planTongzi}</Data></Cell>
<!--     <Cell ss:StyleID="s26"><Data ss:Type="String">{if $aGang.haveSt==true}√{else}&nbsp;{/if}</Data></Cell>
    <Cell ss:StyleID="s26"><Data ss:Type="String">{if $aGang.haveRs==true}{if $aGang.haveRs==3}√√{else}√{/if}{else}&nbsp;{/if}</Data></Cell>
    <Cell ss:StyleID="s26"><Data ss:Type="String">{if $aGang.haveHs==true}√{else}&nbsp;{/if}</Data></Cell>
    <Cell ss:StyleID="s26"><Data ss:Type="String">{if $aGang.haveHd==true}√{else}&nbsp;{/if}</Data></Cell>
    <Cell ss:StyleID="s26"><Data ss:Type="String">{if $aGang.haveFh==true}√{else}&nbsp;{/if}</Data></Cell>
    <Cell ss:StyleID="s26"><Data ss:Type="String">{$item.personDayangName}</Data></Cell> -->
   </Row>
   {/if}
    {/foreach}
    {else}    
    {math equation="x+y " x=$item.cntKg y=$tCnt assign='tCnt'}
    {/if}
    {/if}
    {/foreach}
  {/foreach}  
   <Row>
    <Cell ss:StyleID="s22"><Data ss:Type="String">合计</Data></Cell>
    <Cell ss:StyleID="s22"/>
    <Cell ss:StyleID="s22"/>
    <Cell ss:StyleID="s22"/>
    <Cell ss:StyleID="s22"/>
    <Cell ss:StyleID="s22"/>
    <Cell ss:StyleID="s22"><Data ss:Type="Number">{$tCnt}</Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="Number">{$tTongzi}</Data></Cell>
<!--     <Cell ss:StyleID="s22"/>
    <Cell ss:StyleID="s22"/>
    <Cell ss:StyleID="s22"/>
    <Cell ss:StyleID="s22"/>
    <Cell ss:StyleID="s22"/>
    <Cell ss:StyleID="s22"/> -->
   </Row>
   {/if}
  {/foreach}
<!--    <Row ss:Index="8">
    <Cell ss:Index="10" ss:StyleID="s21"/>
   </Row> -->
  </Table>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <Print>
    <ValidPrinterInfo/>
    <PaperSizeIndex>9</PaperSizeIndex>
    <HorizontalResolution>600</HorizontalResolution>
    <VerticalResolution>600</VerticalResolution>
   </Print>
   <Selected/>
   <Panes>
    <Pane>
     <Number>3</Number>
     <ActiveRow>7</ActiveRow>
     <ActiveCol>9</ActiveCol>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
 <Worksheet ss:Name="Sheet2">
  <Table ss:ExpandedColumnCount="0" ss:ExpandedRowCount="0" x:FullColumns="1"
   x:FullRows="1" ss:DefaultColumnWidth="54" ss:DefaultRowHeight="14.25"/>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
 <Worksheet ss:Name="Sheet3">
  <Table ss:ExpandedColumnCount="0" ss:ExpandedRowCount="0" x:FullColumns="1"
   x:FullRows="1" ss:DefaultColumnWidth="54" ss:DefaultRowHeight="14.25"/>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>
