# Makefile pour les exemples du tutoriel d'OpenGL ...

INCPATH = -I /usr/local/include -I /usr/X11R6/include -I/public/ig/glm/ -I/public/ig/glm/glm/
LIBPATH = -L /usr/local/lib -L /usr/X11R6/lib -L /usr/lib64
LIBRARY =  -lstdc++ -lGL -lglfw -lX11  -lXxf86vm -lpthread -lXrandr -lXi -lopencv_core -lopencv_imgproc -lopencv_highgui -lGLEW 

CFLAGS = -Wall $(INCPATH)
LDFALGS = -Wall $(LIBPATH) $(LIBRARY)
GCC=/usr/bin/g++
SRC=src

all:
	@echo "Specifiez une cible"

%.o:$(SRC)/%.cpp
	$(GCC) -ggdb $(CFLAGS) -o $@ -c $<

%:%.o $(SRC)/%.cpp utils-KP-bones-modele.o udp.o
	$(GCC) -o $@ utils-KP-bones-modele.o udp.o $<  $(LDFALGS)

# cette commande permet de supprimer tous les objets
clean:
	@rm -f `/bin/ls *.o | grep -v Makefile | grep -v $(SRC)`
