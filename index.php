
 <?php  
ini_set('display_errors', 1);
define('SERVER', 'localhost');
define('DBNAME', 'teste');
define('USER', 'root');
define('PASSWORD', 'Pettersen.18');

try 
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['function'])) 
    {
        $functionName = $_GET['function'];    
        $opcoes = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
        $Conexao = new PDO("mysql:host=" . SERVER . ";dbname=" . DBNAME, USER, PASSWORD, $opcoes);
        if ($functionName === 'DeletarPai') 
        {
            if (isset($_POST['idPai'])) 
            {
                $pai_id = $_POST['idPai'];
                $query = "CALL DeletarPaiEFilhos(?)";
                $stmt = $Conexao->prepare($query);
                $stmt->bindParam(1, $pai_id, PDO::PARAM_INT);
                if ($stmt->execute()) 
                {
                    echo "Pai e Filhos excluídos com sucesso!";
                } 
                else 
                {
                    echo "Erro ao excluir Pai e Filhos.";
                }
            }
        } 
    }      
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['function'])) 
    {
        $functionName = $_GET['function'];
        $opcoes = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
        $Conexao = new PDO("mysql:host=" . SERVER . ";dbname=" . DBNAME, USER, PASSWORD, $opcoes);
        if ($functionName === 'Getfamilia') 
        {
            // Your code to execute the 'Getfamilia' function
            $SQL = 'CALL GetPaiFilhosJSON();';
            $STM = $Conexao->prepare($SQL);
            $STM->execute();
            $result = $STM->fetchAll(PDO::FETCH_ASSOC);
            $response = array();
            foreach ($result as $row) 
            {
                $dataResult = json_decode($row['DATA_RESULT'], true);
                $response[] = array(
                    'Id' => $dataResult['Id'],
                    'Pai' => $dataResult['Pai'],
                    'Filhos' => $dataResult['Filhos']
                );
            }
    
            // Output the result as JSON
            echo json_encode($response);
        } 
        else 
        {
            // Handle other functions if needed
            echo "Function not found";
        }
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['function'])) 
    {
        $functionName = $_GET['function'];
        $opcoes = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
        $Conexao = new PDO("mysql:host=" . SERVER . ";dbname=" . DBNAME, USER, PASSWORD, $opcoes);
       
        if ($functionName === 'adicionarPaiFilho') 
        {
            $nomePai = $_POST['nomePai'];
            $nomesFilhos = isset($_POST['nomesFilhos']) ? $_POST['nomesFilhos'] : [];
             
        
            if (empty($nomePai)) 
            {
                echo "Nome do Pai não pode estar em branco.";
            } 
            else 
            {
                $query = "CALL AdicionarPaiEFilhos(?, ?)";
                $stmt = $Conexao->prepare($query);
                $filhos_json = json_encode($nomesFilhos);
                $stmt->bindParam(1, $nomePai, PDO::PARAM_STR);
                $stmt->bindParam(2, $filhos_json, PDO::PARAM_STR);

                if ($stmt->execute()) 
                {
                    echo "Pai e Filhos adicionados com sucesso!";
                } 
                else 
                {
                    echo "Erro ao adicionar Pai e Filhos.";
                }
            } 
        }
    } 
}    

catch (PDOException $erro) 
{
    echo 'Mensagem de erro: ' . $erro->getMessage() . '\n';
    echo 'Nome do Arquivo: ' . $erro->getFile() . '\n';
    echo 'Linha: ' . $erro->getLine() . '\n';
}
?>
