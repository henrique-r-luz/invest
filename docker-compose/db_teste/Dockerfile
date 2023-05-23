FROM postgres:12.6
# Switch USER to root
USER root
# ajuste de timezone
RUN echo America/Sao_Paulo > /etc/timezone && dpkg-reconfigure --frontend noninteractive tzdata
# mudanca de codificacao para pt_br
RUN localedef -i pt_BR -c -f UTF-8 -A /usr/share/locale/locale.alias pt_BR.UTF-8
ENV LANG pt_BR.utf8
