Delimiter |
Create trigger Orders_account_delete
after
delete on compte
for each row 
begin
	DELETE FROM commande 
    WHERE idcompte = old.idcompte;
end|

Delimiter |
Create trigger Orders_spectacle_delete
after
delete on spectacle
for each row 
begin
	DELETE FROM commande 
    WHERE idspectacle = old.idspectacle;
end|