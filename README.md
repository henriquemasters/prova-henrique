# TESTE 123 Milhas &middot; API  de agrupmento de vôos

Retorna os vôos disponibilizados pelo endpoint [http://prova.123milhas.net/api/flights](http://prova.123milhas.net/api/flights) da empresa **123 Milhas** de forma agrupada. O grupo é um conjunto de vôos ida + volta, que tem o mesmo tipo de tarifa. Este projeto é apenas para carater de teste/avaliação.

Link de demonstração: [DEMO](http://prova.123milhas.net/api/flights)

### Regras de Agrupamento:

* Deve-se gerar grupos com uma ou mais opções de ida e volta;
* Dentro de um mesmo grupo não podem ter vôos de tarifas diferentes;
* Ao formar um grupo é necessário criar um identificador único;
* Todo grupo deve ter um preço total.


## Instalação

1. Navegue pelo terminal até a raíz onde ficam os projetos em seu servidor local;
2. Execute no terminal o comando:

```bash
git clone https://github.com/henriquemasters/prova-henrique.git
```
3. Navegue até a pasta do projeto (prova-henrique) e execute o comando:

```bash
composer update
```

## Executando em localhost

Em seu navegador acesse: http://localhost/prova-henrique/public/api/flights

## Documentação da API
A documentação dos endpoints pode ser vista [aqui](http://prova.123milhas.net/api/flights).

## License
[MIT](https://choosealicense.com/licenses/mit/)
