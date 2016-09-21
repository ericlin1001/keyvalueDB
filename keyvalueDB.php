<html>
<title>KeyValueServer-ByEricLin</title>
<body>
<?php
class KeyValue{
	private $fileName;
	private $f;
	//private $data;
	private $map;
	function __construct(){
		$fileName="keyvalueDB.txt";
		if (!file_exists($fileName)){
			$f=fopen($fileName,'w') or die("Cannot create file:".$fileName);
			fclose($f);
		}
		$f=fopen($fileName,'r') or die("Cannot read file:".$fileName);
		if (filesize($fileName)>0){
			$data=fread($f,filesize($fileName));
			fclose($f);
		}else{
			$data="";
		}
		//echo "before Data:".$data."\n";
		$this->fileName=$fileName;
		$this->f=$f;
		//$this->data=$data;
		//deal with $data.
		$lines=explode("\n",$data);
		$len=count($lines);
		for($i=0;$i<$len;$i++){
			$line=$lines[$i];
			$j=strpos($line,"=>");
			if($j || $j==0){
				$k=substr($line,0,$j);
				$v=substr($line,$j+2);
				if($k=="" || $v==""){
				}else{
					$this->map[$k]=$v;
				}
			}else{
				//Can't not find =>. fails, ignore this line.
			}
		}
	}
	function __destruct(){
		$data="";
		if(isset($this->map)){
			foreach($this->map as $k=>$v){
				if($v==""){
				}else{
					$data=$data.$k."=>".$v."\n";
				}
			}
		}
		//echo "after Data:".$this->$data."\n";
		$this->f=fopen($this->fileName,'w');
		fwrite($this->f,$data);
		fclose($this->f);
	}
	function get($key){
		if(isset($this->map)&&!array_key_exists($key,$this->map)){
			return "";
		}
		return $this->map[$key];
	}
	function set($key,$value){
		$this->map[$key]=$value;
	}
	function del($key){
		if(isset($this->map)&&!array_key_exists($key,$this->map)){
			return ;
		}
		unset($this->map[$key]);
	}
	function getKeys(){
		if(!isset($this->map)){
			return array();
		}
		return array_keys($this->map);
	}
	function printTable(){
		echo "<table border=\"1\">\n";
		echo "<tr><th>Key</th><th>Value</th></tr>\n";

		if(isset($this->map)){
			foreach($this->map as $k=>$v){
				echo "<tr><td>".$k."</td><td>".$v."</td></tr>\n";
			}
		}
		echo "</table>\n";
	}

};
//deal with $data.
function testKeyValue(){
	$kv=new KeyValue();
	$kv->set("k1","v6");
	$kv->set("k3","v8");
	//$kv->del("k3");
	$kv->del("k1");
	echo "k3=".$kv->get("k3")."\n";
	echo "k5=".$kv->get("k5")."\n";
	echo join(",",$kv->getKeys());
}
function main(){
	$kv=new KeyValue();
	$method="";
	$key="";
	$value="";
	if(isset($_GET["method"])){
		$method=$_GET["method"];
	}
	if(isset($_GET["key"])){
	$key=$_GET["key"];
	}
	if(isset($_GET["value"])){
	$value=$_GET["value"];
	}
	echo "Result:<!--ResultBegin-->";
	if($method=="get"){
		echo $kv->get($key);
	}else if($method=="set"){
		echo $kv->set($key,$value);
	}else if($method=="del"){
		echo $kv->del($key);
	}else if($method=="keys"){
		echo join("<br/>\n",$kv->getKeys($key));
	}else if($method=="help"){
	echo "method=get,set,del,keys,help.<br/>\n";
	echo "Author:Ericlin(463222898@qq.com)<br/>\n";
	}else if($method==""){

	}else{
		//Error
		echo "Errors:No this method.\n";
	}
	echo "<!--ResultEnd-->\n";
		?>
<form action="" method="get" >
Method:<input type="radio" name="method" value="get">get <br/> 
<input type="radio" name="method" value="set">set <br/> 
<input type="radio" name="method" value="del">del <br/> 
<input type="radio" name="method" value="keys">get all keys <br/> 
<input type="radio" name="method" value="help">help <br/> 
Key:<input type="text" name="key"><br/>
Value:<input type="text" name="value"><br/>
<input type="submit" ><br/>
</form>
<?php
		$kv->printTable();
}
main();
?>
</body>
</html>
