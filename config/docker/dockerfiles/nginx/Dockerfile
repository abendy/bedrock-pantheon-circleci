ARG NGINX_VERSION
FROM nginx:${NGINX_VERSION}

# Update & upgrade packages
RUN apk --quiet --no-cache update \
  && apk --quiet --no-cache upgrade

# Set timezone
ARG TZ
RUN apk --quiet --no-cache add tzdata \
  && cp "/usr/share/zoneinfo/$TZ" /etc/localtime \
  && echo "$TZ" > /etc/timezone

# Install bash
RUN apk add --quiet --no-cache bash

# Install ngxtop
RUN apk add --quiet --no-cache py-pip \
  && pip install ngxtop &> /dev/null

WORKDIR /etc/nginx

CMD ["nginx", "-g", "daemon off;"]
