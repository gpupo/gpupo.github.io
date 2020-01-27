
## Build files
build:
	./bin/console repos:list -v

## Rebuild files
rebuild:
	rm -fv Resources/data/*.yaml
	./bin/console repos:list -v
